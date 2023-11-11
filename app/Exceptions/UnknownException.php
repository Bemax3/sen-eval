<?php

namespace App\Exceptions;

use Exception;

class UnknownException extends Exception
{
    protected $message = 'Une erreur est survenue, veuillez réessayer plus tard.';
}
