<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUsersFromOracle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:oracle:users'; // Correction de la signature

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from Oracle database and update them in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $users = User::where('user_first_name', '=', null)
            ->where('user_matricule', '!=', null)
            ->get();
            
        foreach ($users as $user) {
            if ($user->user_matricule == null) {
                $user->delete(); 
                continue;
            }

            if (!$this->updateUserWithOracleData($user)) { // Correction de l'appel
                $user->delete();
            }
        } 
        
    }



    public function updateUserWithOracleData($user): bool
    {
        try {
            $today = Carbon::today();
            $oracleUser = DB::connection('oracle')
                ->select(\File::get(app_path() . '/Oracle/GetEmployee.sql'), [
                    'matri' => $user->user_matricule, 
                    'eff_date' => $today
                ])[0];

            

            if ($oracleUser == null) {
                return false;
            }

            // Mise à jour des informations utilisateur
            $user->update([
                'user_first_name' => $oracleUser->prenom,
                'user_last_name' => $oracleUser->nom,
                'user_title' => $oracleUser->poste,
                'user_responsibility_center' => $oracleUser->centre_de_responsabilite,
                'user_gf' => $oracleUser->gf,
                'user_nr' => $oracleUser->nr,
                'org_id' => $oracleUser->org_id,
            ]);

            $user->update([
                'user_gf_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promogf)->toDateTimeString(),
                'user_nr_prom_date' => Carbon::createFromFormat('d-M-Y', $oracleUser->date_promonr)->toDateTimeString(),
                'group_id' => Group::where('group_code', '=', strtolower($oracleUser->college))
                    ->first()->group_id,
            ]);
            return true;
        } catch (\Exception $e) {
            // Vous pouvez ajouter un logging ici pour capturer l'exception
            return false;
        }
    }
}
