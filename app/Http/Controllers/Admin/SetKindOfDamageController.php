<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KindOfDamageType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetKindOfDamageController extends Controller
{
    public function index() {
        return view('admin.set-kind-of-damage-device.index');
    }

    public function data() {
        return datatables()
                ->of(KindOfDamageType::all())
                ->addIndexColumn()
                ->addColumn(
                    'item',
                    function($q) {
                        return $q->item->name;
                    }
                )
                ->addColumn(
                    'severity',
                    function($q) {
                        return $q->severity->name;
                    }
                )
                ->toJson();
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new KindOfDamageType();
            $data->name = $request->name;
            $data->item_id = $request->item_id;
            $data->category = $request->category;
            $data->severity_configuration_id = $request->severity_configuration_id;
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
            $data = KindOfDamageType::find($id);
            $data->name = $request->name;
            $data->item_id = $request->item_id;
            $data->category = $request->category;
            $data->severity_configuration_id = $request->severity_configuration_id;
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
            $data = KindOfDamageType::find($request->id);
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
