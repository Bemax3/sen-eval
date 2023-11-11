<?php

namespace App\Exceptions\Goal;

use Exception;

class GoalMarkExceedMarkingException extends Exception
{
    protected $message = 'Le barème ne peut pas être inférieure á la note déjà donnée.';
}
