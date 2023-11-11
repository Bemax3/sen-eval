<?php

namespace App\Exceptions\Goal;

use Exception;

class GoalsMarkingExceededException extends Exception
{
    protected $message = 'Le barème total pour les objectifs dépasse la limite fixée.';
}
