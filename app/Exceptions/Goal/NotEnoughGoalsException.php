<?php

namespace App\Exceptions\Goal;

use Exception;

class NotEnoughGoalsException extends Exception
{
    protected $message = 'Pas assez d\'objectifs crées pour valider cette évaluation.';
}
