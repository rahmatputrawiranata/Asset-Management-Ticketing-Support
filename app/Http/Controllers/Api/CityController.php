<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends ApiController
{

    public function allData() {

        $data = $this->createSelectDataFormat(City::get(), 'id', 'name');

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
            'status_code' => 200,
            'data' => $data
        ], 200);

    }

    public function all($id) {

        return response()->json([
            'status' => 'success',
            'message' => 'Success!!',
            'status_code' => 200,
            'data' => City::where('ns', $id)->get()
        ], 200);

    }

    public function selectDataFormat($id) {

        $data = $this->createSelectDataFormat(City::where('regions_id', $id)->get(), 'id', 'name');

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
            'status_code' => 200,
            'data' => $data
        ], 200);
    }
}
