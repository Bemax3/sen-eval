<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class SanctionType extends Model implements Searchable
{
    protected $table = 'sanction_types';
    protected $primaryKey = 'sanction_type_id';
    protected $fillable = ['sanction_type_name', 'sanction_type_desc'];

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
}
