<?php

namespace App\Models\Evaluation;

use App\Models\Phase\Phase;
use App\Models\Phase\PhaseSkill;
use App\Models\Settings\SkillType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Evaluation extends Model implements Searchable
{
    protected $table = 'evaluations';
    protected $primaryKey = 'evaluation_id';
    protected $fillable = ['evaluated_id','evaluator_id','phase_id','evaluator_comment','evaluated_comment','evaluation_mark'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function evaluated(): BelongsTo
    {
        return  $this->belongsTo(User::class,'evaluated_id','user_id');
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class,'evaluator_id','user_id');
    }

    public function skills(): HasMany {
        return $this->hasMany(EvaluationSkill::class,'evaluation_id','evaluation_id')->with('phaseSkill');
    }

    public function general_skills(): HasMany {
        return $this->skills()->whereHas('phaseSkill.skill',function ($query) {
                $query->where('skill_type_id','=',SkillType::GENERAL);
        });
    }

    public function specific_skills(): HasMany {
        return $this->skills()->whereHas('phaseSkill.skill',function ($query) {
            $query->where('skill_type_id','=',SkillType::SPECIFIC);
        });
    }

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class,'phase_id','phase_id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->evaluation_id,
        );
    }
}
