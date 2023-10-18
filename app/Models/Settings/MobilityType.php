<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class MobilityType extends Model implements Searchable
{
    protected $table = 'mobility_types';
    protected $primaryKey = 'mobility_type_id';
    protected $fillable = ['mobility_type_name', 'mobility_type_desc'];

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
}
