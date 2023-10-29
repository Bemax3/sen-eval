<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Organisation extends Model implements Searchable
{
    protected $table = 'organisations';
    protected $primaryKey = 'org_id';
    protected $fillable = ['org_id','org_name','org_type','org_responsibility_center','parent_id','updated_by'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function child_org_agents() : HasManyThrough {
        return $this->hasManyThrough(User::class,$this,'parent_id','org_id','org_id','org_id');
    }

    public function org_agents(): HasMany
    {
        return  $this->hasMany(User::class);
    }

    public function users() {
        return array_merge($this->child_org_agents()->get()->toArray(),$this->org_agents()->get()->toArray());
    }

    public function parent(): BelongsTo {
        return $this->belongsTo($this,'parent_id','org_id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->org_id,
        );
    }
}
