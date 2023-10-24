<?php

namespace App\Oracle;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportUsersFromOracle
{
    public function __invoke(): void
    {
        $users = User::whereRelation('role','role_code','user')->get();
        foreach ($users as $user) {
            if (!$user->user_matricule) continue;
            $oracleUser =  DB::connection('oracle')->select(\File::get(app_path() . '/Oracle/GetEmployee.sql'),['MATRICULE' => $user->user_matricule,'eff_date'=> Carbon::today()]);
            if(!count($oracleUser)) continue;
            $user->update([
                'user_first_name' => $oracleUser[0]->prenom,
                'user_last_name' => $oracleUser[0]->nom,
                'user_title' => $oracleUser[0]->poste,
                'user_gf' => $oracleUser[0]->gf,
                'user_nr' => $oracleUser[0]->nr,
            ]);
        }
    }

}
