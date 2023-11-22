<?php

namespace App\Exceptions\Rating;

use Exception;

class ValidatorAlreadyExistException extends Exception
{
    protected $message = 'L\'évaluation est déjà transférée á cet agent pour validation.';
}
