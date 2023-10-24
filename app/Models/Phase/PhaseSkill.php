<?php

namespace App\Models\Phase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhaseSkill extends Model
{
    use SoftDeletes;

    protected $table = 'phase_skills';

    protected $primaryKey = 'phase_skill_id';

    protected $fillable = ['phase_id','skill_id','phase_skill_marking','phase_skill_is_active'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }
}
