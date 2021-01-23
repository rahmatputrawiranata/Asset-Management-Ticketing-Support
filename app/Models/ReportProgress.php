<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportProgress extends Model
{
    use SoftDeletes;

    public function masterData() {
        return $this->belongsTo(MasterData::class, 'progress_code', 'key');
    }
}
