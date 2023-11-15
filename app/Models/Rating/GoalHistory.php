<?php

namespace App\Models\Rating;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalHistory extends Model
{
    protected $table = 'goal_history';
    protected $primaryKey = 'goal_history_id';
    protected $fillable = [
        'comment',
        'goal_rate',
        'goal_id',
        'updated_by'
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class, 'goal_id', 'goal_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
}
