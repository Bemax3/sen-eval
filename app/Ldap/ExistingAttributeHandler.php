<?php

namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUSer;


class ExistingAttributeHandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database): void
    {
        $split = explode(' ', $ldap->getFirstAttribute('company'));
        $database->user_matricule = array_key_exists(1,$split) ? $split[1] : null;
    }
}
