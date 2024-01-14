<?php

namespace App\Exceptions\Rating;

use Exception;

class AgentIsNotEligibleForPromotionException extends Exception
{
    protected $message = 'Cet agent n\'est pas éligible à une promotion.';
}
