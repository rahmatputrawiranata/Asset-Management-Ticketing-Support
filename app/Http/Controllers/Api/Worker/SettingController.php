<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\ApiController;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends ApiController
{
    public function updateStatus(Request $request) {
        $user = Auth::user();
        $worker = Worker::find($user->id);
        $worker->is_active = $request->status;
        $worker->save();

        return $this->respondSuccess('success', $worker->load('assignmentCity'));
    }

    public function updateCurrentLocation(Request $request) {
        $user = Auth::user();
        $worker = Worker::find($user->id);
        $worker->current_latitude = $request->current_latitude;
        $worker->current_longitude = $request->current_longitude;
        $worker->save();

        return $this->respondSuccess('success', $worker->load('assignmentCity'));
    }
}
