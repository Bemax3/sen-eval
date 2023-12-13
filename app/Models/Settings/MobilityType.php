<?php

namespace App\Models\Settings;

use App\Models\Rating\Mobility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class MobilityType extends Model implements Searchable
{
    protected $table = 'mobility_types';
    protected $primaryKey = 'mobility_type_id';
    protected $fillable = ['mobility_type_name', 'mobility_type_desc', 'mobility_type_is_active', 'updated_by', 'mobilities_by_evaluators', 'mobilities_by_evaluated'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->mobility_type_name,
        );
    }

    public function mobilities(): HasMany
    {
        return $this->hasMany(Mobility::class, 'mobility_type_id', 'mobility_type_id');
    }
}
