<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function index() {
        return view('admin.worker.index');
    }

    public function data() {
        return datatables()
                ->of(Worker::all())
                ->addIndexColumn()
                ->make();
    }

    public function create(Request $request) {

        DB::beginTransaction();
        try {
            $data = new Worker();
            $data->name = $request->type;
            $data->full_name = $request->full_name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->username = $request->username;
            $data->password = Hash::make($request->password);
            $data->user = Auth::user()->id;
            $data->save();

            foreach($data->city as $row){
                // $data = new
            }

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
            $data = Worker::find($id);
            $data->name = $request->type;
            $data->full_name = $request->full_name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->username = $request->username;
            $data->password = Hash::make($request->password);
            $data->user = Auth::user()->id;
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
            $data = Worker::find($request->id);
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
