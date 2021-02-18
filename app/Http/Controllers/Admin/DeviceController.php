<?php

namespace App\Http\Controllers\Admin;

use App\DeviceSetUp;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\KindOfDamageType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index() {
        return view('admin.device.index');
    }

    public function data() {
        return datatables()
                ->of(Device::all())
                ->addIndexColumn()
                ->addColumn('assignment_problem_details_id', function($q) {
                    $res = $q->assignmentPromblemDetails()->pluck('kind_of_damage_types.id');
                    return $res;
                })
                ->make();
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new Device();
            $data->device_code = $request->device_code;
            $data->device_model = $request->device_model;
            $data->spesification = $request->spesification;
            $data->notes = $request->notes;
            $data->save();

            DeviceSetUp::where('device_id', $data->id)->delete();

            $data = collect($request->problem_details)->map(function($item, $key) use($data) {
                $dataDetail = KindOfDamageType::find($item);
                return [
                    'device_id' => $data->id,
                    'kind_of_damage_type_id' => $dataDetail->id,
                    'item_id' => $dataDetail->item_id,
                ];
            });
            DeviceSetUp::insert($data->toArray());

        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }

        DB::commit();
        return response()->json([
            'status' => 'error',
            'status_code' => 200,
            'message' => 'Success',
            'data' => []
        ]);

    }

    public function update($id, Request $request) {

        DB::beginTransaction();
        try{
            $data = Device::find($id);
            $data->device_code = $request->device_code;
            $data->device_model = $request->device_model;
            $data->spesification = $request->spesification;
            $data->notes = $request->notes;
            $data->save();

            DeviceSetUp::where('device_id', $data->id)->delete();

            $data = collect($request->problem_details)->map(function($item, $key) use($data) {
                $dataDetail = KindOfDamageType::find($item);
                return [
                    'device_id' => $data->id,
                    'kind_of_damage_type_id' => $dataDetail->id,
                    'item_id' => $dataDetail->item_id,
                ];
            });
            DeviceSetUp::insert($data->toArray());
        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
        DB::commit();
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Success',
            'data' => []
        ]);
    }

    public function delete(Request $request) {
        DB::beginTransaction();
        try{
            $data = Device::findOrFail($request->id);
            $data->delete();
        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
        DB::commit();
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'success',
            'data' => []
        ]);

    }
}
