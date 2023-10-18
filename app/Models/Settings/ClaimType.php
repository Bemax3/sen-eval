<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ClaimType extends Model implements Searchable
{
    protected $table = 'claim_types';
    protected $primaryKey = 'claim_type_id';
    protected $fillable = ['claim_type_name', 'claim_type_desc'];

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
}
