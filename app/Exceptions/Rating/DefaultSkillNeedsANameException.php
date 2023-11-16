<?php

namespace App\Exceptions\Rating;

use Exception;

class DefaultSkillNeedsANameException extends Exception
{
    protected $message = 'Veuillez fournir un nom pour cette compétence.';
}
