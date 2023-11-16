<?php

namespace App\Exceptions\Rating;

use Exception;

class SkillAlreadyExistException extends Exception
{
    protected $message = 'Cette compétence existe déjà.';
}
