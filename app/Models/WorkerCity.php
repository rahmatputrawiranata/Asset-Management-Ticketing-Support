<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerCity extends Model
{
    protected $fillable = [
        'worker_id',
        'city_id'
    ];

    public $timestamps = false;
}
