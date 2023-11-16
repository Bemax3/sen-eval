<?php

namespace App\Exceptions\Rating;

use Exception;

class SkillsMarksReachedFixedLimitException extends Exception
{
    protected $message = 'Le total des notes pour cette section a atteint 30 points';
}
