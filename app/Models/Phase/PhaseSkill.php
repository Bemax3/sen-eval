<?php

namespace App\Models\Phase;

use App\Models\Rating\Rating;
use App\Models\Rating\RatingSkill;
use App\Models\Settings\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhaseSkill extends Model
{
    protected $table = 'phase_skills';

    protected $primaryKey = 'phase_skill_id';

    protected $fillable = ['phase_id', 'skill_id', 'phase_skill_marking', 'phase_skill_is_active', 'updated_by'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(Rating::class, 'rating_skills', 'phase_skill_id', 'rating_id')->withPivot('rating_skill_mark', 'rating_skill_mark_is_claimed');
    }

    public function rating_skills(): HasMany
    {
        return $this->hasMany(RatingSkill::class, 'phase_skill_id', 'phase_skill_id');
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }
}
