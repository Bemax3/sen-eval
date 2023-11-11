<?php

namespace App\Exceptions\Rating;

use Exception;

class UserCantEvaluateHimselfException extends Exception
{
    protected $message = 'Ahh Non! Vous n\'êtes pas autorisé á vous évaluer.';
}
