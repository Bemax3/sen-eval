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
        $oracleUsers =  DB::connection('oracle')->select(\File::get(app_path() . '/Oracle/GetEmployees.sql'),['eff_date'=> Carbon::today()]);
//        $orgs = Organisation::selectRaw('SUBSTRING(org_responsibility_center,1,2) as org_rc, org_id')
////            ->where('org_type','=','DIR')
//            ->whereRaw('SUBSTRING(org_name,1,2) != \'EM\'')
////            ->orderBy('org_responsibility_center','ASC')
//            ->get();
//        ray($orgs);
//        $rcAsIndex = array();
//        foreach ($orgs as $org) $rcAsIndex[$org->org_rc] = $org->org_id;
//        ray($rcAsIndex);
        foreach ($oracleUsers as $oracleUser) {
//            ray()->once($oracleUser);
            $user = User::updateOrCreate(['user_id' => $oracleUser->person_id],[
                'user_matricule' => $oracleUser->matricule,
                'user_first_name' => $oracleUser->prenom,
                'user_last_name' => $oracleUser->nom,
                'user_title' => $oracleUser->poste,
                'user_responsibility_center' => $oracleUser->centre_de_responsabilite,
                'user_gf' => $oracleUser->gf,
                'user_nr' => $oracleUser->nr,
                'group_id' => Group::where('group_code', '=', strtolower($oracleUser->college))->first()->group_id,
                'role_id' => Role::USER,
            ]);
            try {
//                ray(substr($user->user_responsibility_center,0,2));
//                ray($rcAsIndex['"'.substr($user->user_responsibility_center,0,2).'"']);
                $user->update([
                    'user_gf_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promogf)->toDateTimeString(),
                    'user_nr_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promonr)->toDateTimeString(),
                    'org_id' => $oracleUser->org_id
//                        $rcAsIndex[substr($user->user_responsibility_center,0,2)]
                ]);
            }catch (\Exception) {
                continue;
//                User::updateOrCreate(['user_id' => $oracleUser->person_id],[
//                    'user_gf_prom_date' => Carbon::createFromLocaleFormat('d-M-Y','fr' ,$oracleUser->date_promogf)->toDateTimeString(),
//                    'user_nr_prom_date' => Carbon::createFromLocaleFormat('d-M-Y', 'fr',$oracleUser->date_promonr)->toDateTimeString(),
//                ]);

            }
        }
    }

}


//update users set password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' where user_matricule = 'C00589';
//update users set user_login = 'natou.cisse' where user_matricule = 'C00589';
