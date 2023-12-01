<?php

namespace App\Models\Settings;

use App\Models\Rating\Claim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ClaimType extends Model implements Searchable
{
    protected $table = 'claim_types';
    protected $primaryKey = 'claim_type_id';
    protected $fillable = ['claim_type_name', 'claim_type_desc', 'claim_type_is_active', 'updated_by', 'claims_count'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->claim_type_name,
        );
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'claim_type_id', 'claim_type_id');
    }
}
