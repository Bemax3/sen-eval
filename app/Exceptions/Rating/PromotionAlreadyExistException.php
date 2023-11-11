<?php

namespace App\Exceptions\Rating;

use Exception;

class PromotionAlreadyExistException extends Exception
{
    protected $message = 'Cette promotion existe déjà.';
}
