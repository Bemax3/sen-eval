<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rating\Goal;
use App\Models\Rating\Mobility;
use App\Models\Rating\Rating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements LdapAuthenticatable, Searchable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap, HasLdapUser;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_display_name',
        'user_login',
        'user_matricule',
        'user_first_name',
        'user_last_name',
        'user_title',
        'user_gf',
        'user_gf_prom_date',
        'user_nr',
        'user_nr_prom_date',
        'user_image',
        'n1_id',
        'group_id',
        'user_responsibility_center',
        'role_id',
        'org_id',
        'email',
        'guid',
        'domain',
        'password',
        'updated_by'
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
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'org_id', 'org_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    public function n1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'n1_id', 'user_id');
    }

    public function agents(): HasMany
    {
        return $this->hasMany(User::class, 'n1_id', 'user_id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'evaluated_id', 'user_id');
    }

    public function agents_goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'evaluator_id', 'user_id');
    }

    public function mobilities(): HasMany
    {
        return $this->hasMany(Mobility::class, 'asked_by', 'user_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'evaluated_id', 'user_id');
    }

//    public function parent_org: Belongs

    public function isRoot(): bool
    {
        return $this->role_id === Role::ROOT;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    public function isViewer(): bool
    {
        return $this->role_id === Role::VIEWER;
    }

    public function isCadre(): bool
    {
        return $this->group_id === Group::CADRE;
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
