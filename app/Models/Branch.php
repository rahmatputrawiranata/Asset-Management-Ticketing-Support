<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('has-city', function(Builder $builder) {
            $builder->has('city');
        });
    }

    public function city() {
        return $this->belongsTo(City::class, 'cities_id');
    }

}
