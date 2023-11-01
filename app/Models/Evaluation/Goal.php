<?php

namespace App\Models\Evaluation;

use App\Models\Phase\EvaluationPeriod;
use App\Models\Phase\Phase;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Goal extends Model implements Searchable
{
    protected $table = 'goals';
    protected $primaryKey = 'goal_id';
    protected $fillable = [
        'goal_name',
        'goal_comment',
        'goal_means_available',
        'goal_expected_date',
        'goal_expected_result',
        'goal_is_accepted',
        'evaluator_id',
        'evaluated_id',
        'phase_id',
        'goal_marking',
        'evaluation_period_id',
        'goal_mark'
    ];

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

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class,'phase_id','phase_id');
    }
    public function period(): BelongsTo
    {
        return $this->belongsTo(EvaluationPeriod::class,'evaluation_period_id','evaluation_period_id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->goal_id,
        );
    }
}
