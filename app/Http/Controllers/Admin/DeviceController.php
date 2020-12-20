<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index() {
        return view('admin.country.index');
    }

    public function data() {
        return datatables()
                ->of(Device::all())
                ->addIndexColumn()
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
        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => 'Unknow Error!!',
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

    public function delete(Request $request) {
        DB::beginTransaction();
        try{
            $data = Device::find($request->id);
            $data->delete();
        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => 'Unknow Error!!',
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
