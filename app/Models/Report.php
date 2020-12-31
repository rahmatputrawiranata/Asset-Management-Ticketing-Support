<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('has-region', function(Builder $builder) {
            $builder->has('customer')
                    ->has('branch')
                    ->has('worker')
                    ->has('device')
                    ->has('kindOfDamageType');
        });
    }

    public function reportProgress() {
        return $this->hasMany(ReportProgress::class, 'report_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }

    public function worker() {
        return $this->belongsTo(Worker::class, 'worker_id')->withTrashed();
    }

    public function device() {
        return $this->belongsTo(Device::class, 'device_id')->withTrashed();
    }

    public function kindOfDamageType() {
        return $this->belongsTo(KindOfDamageType::class, 'kind_of_damage_type_id')->withTrashed();
    }
}
