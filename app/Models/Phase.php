<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Phase extends Model implements Searchable
{
    protected $table = 'phases';

    protected $primaryKey = 'phase_id';
    protected $fillable = ['phase_name','phase_year','phase_first_eval_start','phase_first_eval_end','phase_second_eval_start','phase_second_eval_end'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->phase_name,
        );
    }
}
