<?php

namespace App\Exceptions\Rating;

use Exception;

class ClaimAlreadyExistException extends Exception
{
    protected $message = 'Cette réclamation existe déja';
}
