<?php

namespace App\Exceptions\Rating;

use Exception;

class SkillsExceedsMarkingException extends Exception
{
    protected $message = 'Le barème a atteint 30 points';
}
