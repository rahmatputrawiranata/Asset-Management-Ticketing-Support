<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KindOfDamageType extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('has-item', function(Builder $builder) {
            $builder->has('item');
            $builder->has('severity');
        });
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function severity() {
        return $this->belongsTo(SeverityConfiguration::class, 'severity_configuration_id');
    }
}
