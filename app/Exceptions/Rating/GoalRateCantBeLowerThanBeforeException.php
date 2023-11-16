<?php

namespace App\Exceptions\Rating;

use Exception;

class GoalRateCantBeLowerThanBeforeException extends Exception
{
    protected $message = 'Le taux de réalisation ne peut pas être inférieur au dernier taux.';
}
