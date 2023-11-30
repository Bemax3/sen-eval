<?php

namespace App\Models\Settings;

use App\Models\Rating\Promotion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class PromotionType extends Model implements Searchable
{
    protected $table = 'promotion_types';
    protected $primaryKey = 'promotion_type_id';
    protected $fillable = ['promotion_type_name', 'promotion_type_desc', 'promotion_type_is_active', 'updated_by'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->promotion_type_name,
        );
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'promotion_type_id', 'promotion_type_id');
    }
}
