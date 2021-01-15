<?php

namespace App\Models;

use App\DeviceSetUp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    public function assignmentPromblemDetails() {
        return $this->belongsToMany(
            KindOfDamageType::class,
            'device_set_ups',
            'device_id',
            'kind_of_damage_type_id'
        );
    }
}
