<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\KindOfDamageType;
use Illuminate\Http\Request;

class ProblemDetailController extends ApiController
{
    public function selectData(Request $request) {
        $data =  $this->createSelectDataFormat(KindOfDamageType::get(), 'id', 'name');

        return $this->respondSuccess('Success!!', $data);

    }
}
