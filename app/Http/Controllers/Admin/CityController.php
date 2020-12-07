<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $city = Region::has('country')->get();
        return view('admin.city.index', compact('city'));
    }

    public function data() {

        return datatables()
                ->of(City::get())
                ->addColumn('country', function(City $q) {
                    return $q->region->country->name;
                })
                ->addColumn('countries_id', function(City $q){
                    return $q->region->country->id;
                })
                ->addColumn('province', function(City $q) {
                    return $q->region->name;
                })
                ->toJson();
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new City();
            $data->regions_id = $request->provinsi;
            $data->name = $request->name;
            $data->save();
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => '500',
                'message' => $e->getMessage(),
                'data' => $e
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
            $data = City::find($id);
            $data->regions_id = $request->provinsi;
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
            $data = City::find($request->id);
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
