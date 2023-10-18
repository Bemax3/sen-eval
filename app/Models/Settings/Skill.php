<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Skill extends Model implements Searchable
{
    protected $table = 'skills';
    protected $primaryKey = 'skill_id';
    protected $fillable = ['skill_name', 'skill_desc', 'skill_type_id'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->skill_name,
        );
    }

    public function type(): BelongsTo {
        return $this->belongsTo(SkillType::class,'skill_type_id','skill_type_id');
    }

}
