<?php

namespace App\Models\Rating;

use App\Models\Settings\TrainingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    protected $table = 'evaluation_trainings';
    protected $primaryKey = 'evaluation_training_id';
    protected $fillable = ['asked_by_evaluator','asked_by_evaluated','evaluation_id','training_type_id'];
    public function getForeignKey()
    {
        return $this->primaryKey;
    }
    public function evaluation(): BelongsTo {
        return $this->belongsTo(Rating::class,'evaluation_id','evaluation_id');
    }
    public function type(): BelongsTo {
        return $this->belongsTo(TrainingType::class,'training_type_id','training_type_id');
    }
}
