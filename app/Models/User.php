<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements LdapAuthenticatable,Searchable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap,SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_display_name',
        'user_login',
        'user_matricule',
        'user_first_name',
        'user_last_name',
        'user_title',
        'user_gf',
        'user_nr',
        'user_image',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getForeignKey()
    {
        return $this->primaryKey;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id','role_id');
    }

    public function isRoot(): bool
    {
        return $this->role_id === Role::ROOT;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role_id === Role::USER;
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->user_id,
        );
    }
}
