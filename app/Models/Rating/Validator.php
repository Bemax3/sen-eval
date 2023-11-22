<?php

namespace App\Models\Rating;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Validator extends Model
{
    protected $table = 'rating_validators';
    protected $primaryKey = 'rating_validator_id';
    protected $fillable = ['rating_validator_comment', 'has_validated', 'validator_id', 'rating_id', 'validated_at'];

    protected $casts = [
        'validated_at' => 'datetime'
    ];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id', 'user_id');
    }

}
