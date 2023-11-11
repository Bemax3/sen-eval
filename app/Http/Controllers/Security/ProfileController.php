<?php

namespace App\Http\Controllers\Security;

use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use App\Oracle\ImportUsersFromOracle;
use App\Services\Security\UserService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $user = User::with('role')->with('org')->with('n1')->with('group')->findOrFail(\Auth::id());
            return Inertia::render('Security/Profile/Profile', [
                'user' => $user,
                'n1s' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : [],
                'orgs' => Organisation::limit(100)->get(),
                'roles' => Role::all()
            ]);
        } catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        return Inertia::render('Auth/SetupUser');
    }

    public function setup(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_matricule' => ['unique:users', 'required'],
            ], [
                'user_matricule' => 'Le matricule renseigné est déjà choisi !'
            ]);
            $user = User::findOrFail(\Auth::id());
            $user->update([
                'user_matricule' => strtoupper($validated['user_matricule'])
            ]);
            ImportUsersFromOracle::updateUserWithOracleData($user);
            $request->session()->regenerate();
            alert_success('Connexion Réussi');
            return redirect()->route('agents.index');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
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
            if ($request->get('n1_id') == $user->user_id) {
                alert_error('Ahh Nonn! Vous ne pouver pas vous evaluer quand même.');
                return redirect()->back();
            }
            $user->update($request->validated());
            alert_success('Profil modifié avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }


}
