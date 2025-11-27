<?php

/** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection PhpUnused */

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\IsPerson;
use App\Traits\Searchable;
use App\Traits\Selectable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;


class User extends Base implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasFactory, Notifiable;
    use IsPerson, Searchable, Selectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'prefix',
        'first_name',
        'last_name',
        'suffix',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'role'              => UserRole::class,
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public array $search_fields = [
        'first_name',
        'last_name',
        'email',
        'id'
    ];
}
