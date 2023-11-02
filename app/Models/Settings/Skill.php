<?php

namespace App\Models\Settings;

use App\Models\Group;
use App\Models\Phase\Phase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Skill extends Model implements Searchable
{
    protected $table = 'skills';
    protected $primaryKey = 'skill_id';
    protected $fillable = ['skill_name', 'skill_desc','skill_marking', 'skill_type_id','skill_is_active','updated_by'];

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
    public function group(): BelongsTo {
        return $this->belongsTo(Group::class,'group_id','group_id');
    }

    public function phases(): BelongsToMany
    {
        return $this->belongsToMany(Phase::class,'phase_skills','skill_id','phase_id')->withPivot('phase_skill_is_active','phase_skill_marking');
    }

}
