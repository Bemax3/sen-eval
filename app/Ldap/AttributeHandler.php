<?php

namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUSer;


class AttributeHandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database): void
    {
        $database->user_login = $ldap->getFirstAttribute('samaccountname');
        $database->user_display_name = $ldap->getFirstAttribute('name');
        $database->email = $ldap->getFirstAttribute('mail');

        $split = explode(' ', $ldap->getFirstAttribute('company'));
        $database->user_matricule = array_key_exists(1,$split) ? $split[1] : null;

//        $database->user_image = $ldap->getFirstAttribute('thumbnailphoto');
    }
}
