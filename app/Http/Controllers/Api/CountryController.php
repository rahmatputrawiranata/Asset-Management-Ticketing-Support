<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends ApiController
{
    public function all() {
        return response()->json([
            'status' => 'success',
            'message' => 'Success!!',
            'status_code' => 200,
            'data' => Country::get()
        ], 200);
    }

    public function selectDataFormat() {
        $data = $this->createSelectDataFormat(Country::all(), 'id', 'name');

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
            'status_code' => 200,
            'data' => $data
        ], 200);
    }
}
