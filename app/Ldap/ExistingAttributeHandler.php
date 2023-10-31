<?php

namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUSer;


class ExistingAttributeHandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database): array
    {
        $split = explode(' ', $ldap->getFirstAttribute('company'));

        return [
            'user_matricule' =>  $split[1]
        ];
    }
}
