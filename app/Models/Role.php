<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public const ROOT = 1;
    public const ADMIN = 2;
    public const USER = 3;
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_code', 'role_desc', 'role_name'];

    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function users(): HasMany
    {
        return  $this->hasMany(User::class);
    }
}
