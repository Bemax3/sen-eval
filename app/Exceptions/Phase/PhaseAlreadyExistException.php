<?php

namespace App\Exceptions\Phase;

use Exception;

class PhaseAlreadyExistException extends Exception
{
    protected $message = 'Une Phase existe pour cette année.';
}
