<?php

namespace App\Exceptions\Rating;

use Exception;

class CantUpdateValidatedRatingException extends Exception
{
    protected $message = 'Impossible de changer une évaluation déjà validée';
}
