<?php

namespace App\Models\Rating;

use App\Models\Phase\PhaseSkill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingSkill extends Model
{
    protected $table = 'rating_skills';
    protected $primaryKey = 'rating_skill_id';
    protected $fillable = ['rating_skill_mark','rating_skill_mark_is_claimed','phase_skill_id','rating_id'];
    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function rating(): BelongsTo {
        return $this->belongsTo(Rating::class,'rating_id','rating_id');
    }
    public function phaseSkill(): BelongsTo {
        return $this->belongsTo(PhaseSkill::class,'phase_skill_id','phase_skill_id')->with('skill');
    }
}
