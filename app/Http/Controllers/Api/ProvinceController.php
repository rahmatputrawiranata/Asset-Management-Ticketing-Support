<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class ProvinceController extends ApiController
{
    public function all($id) {
        return response()->json([
            'status' => 'success',
            'message' => 'Success!!',
            'status_code' => 200,
            'data' => Region::where('countries_id', $id)->get()
        ], 200);
    }

    public function selectDataFormat($id) {
        $data = $this->createSelectDataFormat(
            Region::where('countries_id', $id)->get(),
            'id',
            'name'
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
            'status_code' => 200,
            'data' => $data
        ], 200);
    }
}
