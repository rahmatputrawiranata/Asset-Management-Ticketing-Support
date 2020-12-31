<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends ApiController
{
    public function all(Request $request) {
        $model = Branch::when($request->has('city_id'), function ($q) use($request) {
            $q->where('city_id', $request->city_id);
        })->get();

        return $this->respondSuccess('Success !!', $model);
    }
}
