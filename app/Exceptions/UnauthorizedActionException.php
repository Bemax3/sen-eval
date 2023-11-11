<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedActionException extends Exception
{
    protected $message = 'Vous n\'êtes pas autorisé á faire cette action';
}
