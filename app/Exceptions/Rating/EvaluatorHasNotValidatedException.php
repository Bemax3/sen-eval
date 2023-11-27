<?php

namespace App\Exceptions\Rating;

use Exception;

class EvaluatorHasNotValidatedException extends Exception
{
    protected $message = 'L\'évaluateur n\'a pas encore valider l\'évaluation';
}
