<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends \Illuminate\Database\Eloquent\Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use HasFactory, Authenticatable, Authorizable;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany('App\Models\UserDocument', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function userBank()
    {
        return $this->hasOne('App\Models\UserBankAccount', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function userDetail(): HasOne
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id');
    }
}
