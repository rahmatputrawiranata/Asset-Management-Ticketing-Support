<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Severity;
use App\Models\SeverityConfiguration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeverityController extends Controller
{
    public function index() {
        return view('admin.severity.index');
    }

    public function data() {
        return datatables()
                ->of(SeverityConfiguration::all())
                ->addIndexColumn()
                ->make();
    }

    public function selectDataFormat() {
        $data = $this->createSelectDataFormat(
            SeverityConfiguration::get(),
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

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new SeverityConfiguration();
            $data->name = $request->name;
            $data->response_time = $request->response_time;
            $data->hardware_time = $request->hardware_time;
            $data->software_time = $request->software_time;
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
            $data = SeverityConfiguration::find($id);
            $data->name = $request->name;
            $data->response_time = $request->response_time;
            $data->hardware_time = $request->hardware_time;
            $data->software_time = $request->software_time;
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
            $data = SeverityConfiguration::find($request->id);
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
