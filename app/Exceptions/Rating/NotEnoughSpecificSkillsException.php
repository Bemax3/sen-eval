<?php

namespace App\Exceptions\Rating;

use Exception;

class NotEnoughSpecificSkillsException extends Exception
{
    protected $message = 'Pas assez de compétences spécifique notées pour valider cette évaluation.';
}
