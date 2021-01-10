<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends ApiController
{
    public function findDevice(Request $request) {

        $this->validate($request, [
            'device_code' => 'required'
        ]);

        if(!$model = Device::where('device_code', $request->device_code)->first()) {
            return $this->respondFail('Device Not Found!!');
        }

        return $this->respondSuccess('success', $model);

    }
}
