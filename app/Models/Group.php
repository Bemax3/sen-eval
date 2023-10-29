<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Group extends Model implements Searchable
{
    public const CADRE = 1;
    public const MAITRISE = 2;

    protected $table = 'groups';
    protected $primaryKey = 'group_id';
    protected $fillable = ['group_name','group_code','updated_by'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function users(): HasMany
    {
        return  $this->hasMany(User::class);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->role_code,
        );
    }
}
