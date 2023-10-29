<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Models\User;
use Exception;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('role')->with('org')->with('n1')->with('group')->findOrFail(\Auth::id());
        return Inertia::render('Security/Profile/Profile', [
            'user' => $user,
            'n1s' => User::where('user_id','!=',$user->user_id)->whereHas('org',function ($query) use ($user) {
                $query->where('organisations.org_id','=',$user->org->org_id)
                    ->orWhere('organisations.org_id','=',$user->org->parent_id)
                    ->orWhere('organisations.parent_id','=',$user->org->parent_id);
            })->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            alert_success('Profil modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de mon profil.');
        } finally {
            return redirect()->back();
        }
    }


}
