<?php

namespace App\Models\Rating;

use App\Models\Settings\PromotionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    protected $table = 'rating_promotions';
    protected $primaryKey = 'rating_promotion_id';
    protected $fillable = ['rating_id', 'promotion_type_id', 'evaluated_is_eligible', 'rating_promotion_comment'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PromotionType::class, 'promotion_type_id', 'promotion_type_id');
    }
}
