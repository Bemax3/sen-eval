<?php

namespace App\Exceptions;

class ModelNotFoundException extends \Illuminate\Database\Eloquent\ModelNotFoundException
{
    protected $message = 'La resource demandée est introuvable.';
}
