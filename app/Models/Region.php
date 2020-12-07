<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('active-country', function(Builder $builder) {
            $builder->has('country');
        });
    }

    public function country() {
        return $this->belongsTo('App\Models\Country', 'countries_id');
    }
}
