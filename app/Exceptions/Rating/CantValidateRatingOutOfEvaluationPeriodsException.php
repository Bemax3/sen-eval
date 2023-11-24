<?php

namespace App\Exceptions\Rating;

use Exception;

class CantValidateRatingOutOfEvaluationPeriodsException extends Exception
{

    protected $message = 'Vous êtes hors des périodes d\'évaluation, vous pouvez cependant enregistrer les notes.';
}
