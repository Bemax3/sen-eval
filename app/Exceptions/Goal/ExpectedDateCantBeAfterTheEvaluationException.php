<?php

namespace App\Exceptions\Goal;

use Exception;

class ExpectedDateCantBeAfterTheEvaluationException extends Exception
{
    protected $message = 'La date de l\'échéance doit appartenir au semestre choisi.';
}
