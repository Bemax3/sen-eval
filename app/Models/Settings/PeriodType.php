<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class PeriodType extends Model implements Searchable
{
    public const YEARLY = 1;
    public const SEMIYEARLY = 2;
    public const TRIMONTHLY = 3;
    public const MONTHLY = 4;

    protected $table = 'period_types';

    protected $primaryKey = 'period_type_id';

    protected $fillable = ['period_type_name','period_type_code','period_type_desc','updated_by'];

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

    public static final function getIdByCode($code) {
            return PeriodType::where('period_type_code',$code)->first()->period_type_id;
    }
}
