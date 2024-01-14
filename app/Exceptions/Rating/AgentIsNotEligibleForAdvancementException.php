<?php

namespace App\Exceptions\Rating;

use Exception;

class AgentIsNotEligibleForAdvancementException extends Exception
{
    protected $message = 'Cet agent n\'est pas éligible à un avancement.';
}
