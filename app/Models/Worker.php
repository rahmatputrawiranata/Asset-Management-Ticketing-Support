<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;

    public function assignmentCity() {
        return $this->belongsToMany(
            City::class,
            'worker_cities',
            'worker_id',
            'city_id',
        );
    }
}
