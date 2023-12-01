<?php

namespace App\Models\Settings;

use App\Models\Rating\Training;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TrainingType extends Model implements Searchable
{
    protected $table = 'training_types';
    protected $primaryKey = 'training_type_id';
    protected $fillable = [
        'training_type_name',
        'training_type_desc',
        'training_type_is_active',
        'updated_by',
        'trainings_by_evaluators',
        'trainings_by_evaluated',
        'asked_by_both',
        'trainings_count'
    ];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->training_type_name,
        );
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }
}
