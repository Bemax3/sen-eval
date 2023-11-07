<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Models\Group;
use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use App\Services\Security\UserService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
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
