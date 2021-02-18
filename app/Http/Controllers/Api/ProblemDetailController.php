<?php

namespace App\Http\Controllers\Api;

use App\DeviceSetUp;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\KindOfDamageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProblemDetailController extends ApiController
{
    public function selectData(Request $request) {
        $data =  $this->createSelectDataFormat(KindOfDamageType::get(), 'id', 'name');

        return $this->respondSuccess('Success!!', $data);

    }

    public function selectDataByDevice($id) {

        $model = DeviceSetUp::where('device_id', $id)
                ->join('kind_of_damage_types', 'kind_of_damage_types.id', '=', 'device_set_ups.kind_of_damage_type_id')
                ->get(DB::raw('kind_of_damage_types.id AS id, kind_of_damage_types.name AS name'));
        // dd($model);
        $data =  $this->createSelectDataFormat($model, 'id', 'name');

        return $this->respondSuccess('Success!!', $data);

    }
}
