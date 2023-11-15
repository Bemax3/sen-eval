<?php

namespace App\Exceptions\Rating;

use Exception;

class NotRatedCorrectlyException extends Exception
{
    protected $message = 'Toutes les notes doivent être supérieure a zero.';
}
