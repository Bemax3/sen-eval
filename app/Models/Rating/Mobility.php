<?php

namespace App\Models\Rating;

use App\Models\Settings\MobilityType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mobility extends Model
{
    protected $table = 'rating_mobilities';
    protected $primaryKey = 'rating_mobility_id';
    protected $fillable = ['rating_id', 'mobility_type_id', 'rating_mobility_nature', 'rating_mobility_title', 'rating_mobility_comment', 'asked_by'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }

    public function asked_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asked_by', 'user_id');
    }

    public function asker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asked_by', 'user_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MobilityType::class, 'mobility_type_id', 'mobility_type_id');
    }
}
