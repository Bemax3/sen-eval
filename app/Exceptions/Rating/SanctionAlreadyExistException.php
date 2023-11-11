<?php

namespace App\Exceptions\Rating;

use Exception;

class SanctionAlreadyExistException extends Exception
{
    protected $message = 'Cette sanction existe déja';
}
