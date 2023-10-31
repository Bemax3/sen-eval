<?php

namespace App\Models\Evaluation;

use App\Models\Phase\PhaseSkill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationSkill extends Model
{
    protected $table = 'evaluation_skills';

    protected $primaryKey = 'evaluation_skill_id';

    protected $fillable = ['evaluation_skill_mark','evaluation_skill_mark_is_claimed','phase_skill_id','evaluation_id'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function evaluation(): BelongsTo {
        return $this->belongsTo(Evaluation::class,'evaluation_id','evaluation_id');
    }

    public function phaseSkill(): BelongsTo {
        return $this->belongsTo(PhaseSkill::class,'phase_skill_id','phase_skill_id')->with('skill');
    }
}
