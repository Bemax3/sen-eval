<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TrainingType extends Model implements Searchable
{
    use SoftDeletes;
    protected $table = 'training_types';
    protected $primaryKey = 'training_type_id';
    protected $fillable = ['training_type_name', 'training_type_desc','training_type_is_active'];

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
}
