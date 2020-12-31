<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index() {
        return view('admin.branch.index');
    }

    public function data() {

        return datatables()
                ->eloquent(Branch::query())
                ->addIndexColumn()
                ->addColumn('country_nmae', function(Branch $q) {
                    return $q->city->region->country->name;
                })
                ->addColumn('countries_id', function(Branch $q){
                    return $q->city->region->country->id;
                })
                ->addColumn('province', function(Branch $q) {
                    return $q->city->region->name;
                })
                ->addColumn('province_id', function(Branch $q) {
                    return $q->city->region->id;
                })
                ->addColumn('city', function(Branch $q) {
                    return $q->city->name;
                })
                ->addColumn('city_id', function(Branch $q) {
                    return $q->city->id;
                })
                ->toJson();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => Str::slug(strtoupper($this->code))
        ]);
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'kota' => 'required',
            'name' => 'required',
            'code' => 'required|unique:branches,code',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $data = new Branch();
            $data->cities_id = $request->kota;
            $data->name = $request->name;
            $data->code = strtoupper($request->code);
            $data->address = $request->address;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->note = $request->note;
            $data->status = 1;
            $data->user = 'admin-'.Auth::user()->id;

            $data->save();
        }catch(Exception $e) {
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

        $this->validate($request, [
            'name' => 'required',
            'kota' => 'required',
            'name' => 'required',
            'code' => 'required|unique:branches,code',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $data = Branch::find($id);
            $data->cities_id = $request->kota;
            $data->name = $request->name;
            $data->code = strtoupper($request->code);
            $data->address = $request->address;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->note = $request->note;
            $data->status = 1;
            $data->user = 'admin-'.Auth::user()->id;

            $data->save();
        }catch(Exception $e) {
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

    public function delete(Request $request){
        DB::beginTransaction();
        try{
            $model = Branch::find($request->id);
            $model->delete();
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

}
