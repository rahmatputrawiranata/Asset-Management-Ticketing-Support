<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;

    protected static function booted()
    {
        static::addGlobalScope('has-branch', function(Builder $builder) {
            $builder->has('branch');
        });
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $hidden = [
        'password',
        'user',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
