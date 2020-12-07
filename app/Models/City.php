<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('has-region', function(Builder $builder) {
            $builder->has('region');
        });
    }

    public function region() {
        return $this->belongsTo(Region::class, 'regions_id');
    }
}
