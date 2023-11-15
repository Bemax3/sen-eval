<?php

namespace App\Exceptions\Goal;

use Exception;

class PeriodGoalsCountLimitReachedException extends Exception
{
    protected $message = 'La limite d\'objectif pour le semestre choisi est atteinte.';
}
