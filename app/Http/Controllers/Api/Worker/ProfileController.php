<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\ApiController;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends ApiController
{
    public function index() {
        $user = Auth::user();
        $user = Worker::find($user->id);
        return $this->respondSuccess('Success!!', $user->load('assignmentCity'));
    }
}
