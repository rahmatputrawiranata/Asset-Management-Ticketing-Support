<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin.region.index');
    }

    public function data() {

        return datatables()
                ->of(Region::has('country')->get())
                ->addColumn('countries', function(Region $q) {
                    return $q->country->name;
                })
                ->toJson();
    }

    public function selectData($id) {
        return Country::all()->toArray();
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new Region();
            $data->countries_id = $request->country;
            $data->name = $request->name;
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
            $data = Region::find($id);
            $data->countries_id = $request->country;
            $data->name = $request->name;
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
            $data = Region::find($request->id);
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
