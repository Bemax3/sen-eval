<?php

namespace App\Exceptions\Rating;

use Exception;

class EvaluatedHasNotValidatedException extends Exception
{
    protected $message = 'L\'évalué n\'a pas encore valider son évaluation';
}
