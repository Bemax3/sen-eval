<?php

namespace App\Models\Phase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class EvaluationPeriod extends Model implements Searchable
{
    use SoftDeletes;

    protected $table = 'evaluation_periods';

    protected $primaryKey = 'evaluation_period_id';

    protected $fillable = ['evaluation_period_end','evaluation_period_start','phase_id'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->evaluation_period_id,
        );
    }

    public function phase() : BelongsTo {
        return $this->belongsTo(Phase::class,'phase_id','phase_id');
    }
}
