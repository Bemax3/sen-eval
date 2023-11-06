<?php

namespace App\Models\Rating;

use App\Models\Settings\ClaimType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    protected $table = 'rating_claims';
    protected $primaryKey = 'rating_claim_id';
    protected $fillable = ['rating_id','claim_type_id'];
    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function rating(): BelongsTo {
        return $this->belongsTo(Rating::class,'rating_id','rating_id');
    }
    public function type(): BelongsTo {
        return $this->belongsTo(ClaimType::class,'claim_type_id','claim_type_id');
    }
}
