<?php

namespace App\Models\Settings;

use App\Models\Rating\Sanction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class SanctionType extends Model implements Searchable
{
    protected $table = 'sanction_types';
    protected $primaryKey = 'sanction_type_id';
    protected $fillable = ['sanction_type_name', 'sanction_type_desc', 'sanction_type_is_active', 'updated_by', 'sanctions_count'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->sanction_type_name,
        );
    }

    public function sanctions(): HasMany
    {
        return $this->hasMany(Sanction::class, 'sanction_type_id', 'sanction_type_id');
    }
}
