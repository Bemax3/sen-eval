<?php

namespace App\Oracle;

use App\Models\Group;
use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportUsersFromOracle
{
    public function __invoke(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->user_matricule == null) {
                $user->delete();
                continue;
            }
            if(!$this::updateUserWithOracleData($user)) continue;
        }
    }

    public static function updateUserWithOracleData($user): bool
    {
        try {
            $oracleUser = DB::connection('oracle')->select(\File::get(app_path() . '/Oracle/GetEmployee.sql'),['matri' => $user->user_matricule,'eff_date'=> Carbon::today()])[0];

            if($oracleUser == null) return false;

            $user->update([
                'user_id' => $oracleUser->person_id,
    //                'user_matricule' => $oracleUser->matricule,
                'user_first_name' => $oracleUser->prenom,
                'user_last_name' => $oracleUser->nom,
                'user_title' => $oracleUser->poste,
                'user_responsibility_center' => $oracleUser->centre_de_responsabilite,
                'user_gf' => $oracleUser->gf,
                'user_nr' => $oracleUser->nr,
                'group_id' => Group::where('group_code', '=', strtolower($oracleUser->college))->first()->group_id,
    //                'role_id' => Role::USER,
            ]);

            $user->update([
                'user_gf_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promogf)->toDateTimeString(),
                'user_nr_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promonr)->toDateTimeString(),
                'org_id' => $oracleUser->org_id
            ]);
            return true;
        }catch (\Exception $e) {
            return false;
//                User::updateOrCreate(['user_id' => $oracleUser->person_id],[
//                    'user_gf_prom_date' => Carbon::createFromLocaleFormat('d-M-Y','fr' ,$oracleUser->date_promogf)->toDateTimeString(),
//                    'user_nr_prom_date' => Carbon::createFromLocaleFormat('d-M-Y', 'fr',$oracleUser->date_promonr)->toDateTimeString(),
//                ]);

        }
    }

}


//update users set password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' where user_matricule = 'C00589';
//update users set user_login = 'natou.cisse' where user_matricule = 'C00589';
