<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Models\Organisation;
use App\Models\User;
use App\Services\Security\UserService;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $orgs = array();
//        Organisation::all();
        $oracleOrgs =  DB::connection('oracle')->select(\File::get(app_path() . '/Oracle/GetOrganisations.sql'));
        foreach ($oracleOrgs as $oracleOrg) {
            if(!str_starts_with($oracleOrg->libelle, 'EM') && preg_match('/[A-Za-z].*[0-9]/',$oracleOrg->centre_resp)) {
                $orgs[] = Organisation::updateOrCreate(['org_id' => $oracleOrg->id],[
                    'org_name' => $oracleOrg->libelle,
                    'org_responsibility_center' => $oracleOrg->centre_resp,
                    'org_type' => $oracleOrg->type,
                ]);
            }
        }

        $rcAsIndex = array();
        foreach ($orgs as $org) $rcAsIndex[$org->org_responsibility_center] = $org->org_id;
        foreach ($orgs as $org)
            try {
                if ($org->updated_by !== null) continue;
                $cr = substr($org->org_responsibility_center,0,3) . '01';
                if(!isset($rcAsIndex[$cr]) || $org->org_responsibility_center === $cr) $cr = substr($org->org_responsibility_center,0,3) . '00';
                if(!isset($rcAsIndex[$cr]) || $org->org_responsibility_center === $cr) $cr = substr($org->org_responsibility_center,0,2) . '001';
                if(!isset($rcAsIndex[$cr]) || $org->org_responsibility_center === $cr) $cr = substr($org->org_responsibility_center,0,2) . '001';
                if(!isset($rcAsIndex[$cr]) || $org->org_responsibility_center === $cr) $cr = substr($org->org_responsibility_center,0,2) . '000';

                if(!isset($rcAsIndex[$cr]) || $org->org_responsibility_center === $cr) $cr = 'DG001';
                $org->update([
                    'parent_id' => $rcAsIndex[$cr]
                ]);
            }catch(\Exception) {
                continue;
            }
        try {
            $user = User::with('role')->with('org')->with('n1')->with('group')->findOrFail(\Auth::id());
            return Inertia::render('Security/Profile/Profile', [
                'user' => $user,
                'n1s' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : []
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            if($request->get('n1_id') == $user->user_id) {
                alert_error('Ahh Nonn! Vous ne pouver pas vous evaluer quand même.');
                return redirect()->back();
            }
            $user->update($request->validated());
            alert_success('Profil modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de mon profil.');
        } finally {
            return redirect()->back();
        }
    }


}
