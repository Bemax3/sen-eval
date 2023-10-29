<?php

namespace App\Services\Security;

use App\Models\User;

class UserService
{
    public function setUserN1($validated,$n1_id): void
    {
        $user = User::where('user_id',$validated['agent_id'])->firstOrFail();
        $user->update(['n1_id' => $n1_id,'updated_by' => $n1_id]);
    }

    public function findSameOrgUsers($user): \Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\_IH_User_C
    {
        return User::where('user_id','!=',$user->user_id)->whereHas('org',function ($query) use ($user) {
            $query->where('organisations.org_id','=',$user->org->org_id)
                ->orWhere('organisations.org_id','=',$user->org->parent_id)
                ->orWhere('organisations.parent_id','=',$user->org->parent_id);
        })->limit(30)->get();
    }
}
