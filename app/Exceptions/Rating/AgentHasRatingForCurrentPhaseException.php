<?php

namespace App\Exceptions\Rating;

use Exception;

class AgentHasRatingForCurrentPhaseException extends Exception
{
    protected $message = 'Cet agent a déjà une évaluation pour l\'année choisi.';
}
