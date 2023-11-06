<?php

namespace App\Models\Rating;

use App\Models\Settings\SanctionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sanction extends Model
{
    protected $table = 'rating_sanctions';
    protected $primaryKey = 'rating_sanction_id';
    protected $fillable = ['rating_id','sanction_type_id'];
    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function rating(): BelongsTo {
        return $this->belongsTo(Rating::class,'rating_id','rating_id');
    }
    public function type(): BelongsTo {
        return $this->belongsTo(SanctionType::class,'sanction_type_id','sanction_type_id');
    }
}
