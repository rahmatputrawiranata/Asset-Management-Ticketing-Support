<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\WorkerCity;
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
                ->addColumn('assignment_city', function($q) {
                    $res = $q->assignmentCity()->pluck('name');
                    return implode(' - ', $res->toArray());
                })
                ->make();
    }

    public function create(Request $request) {

        $this->validate($request, [
            'full_name' => 'required',
            'type' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'password' => 'required',
            'password_reset' => 'same:password'
        ]);
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

            WorkerCity::where('worker_id', $data->id)->delete();

            $data = collect($request->city)->map(function($item, $key) use($data) {
                return [
                    'worker_id' => $data->id,
                    'city_id' => $item
                ];
            });
            WorkerCity::insert($data->toArray());

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
        // dd($request->input());
        DB::beginTransaction();
        try{
            $data = Worker::find($id);
            $data->type = $request->type;
            $data->full_name = $request->full_name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->username = $request->username;
            $data->user = Auth::user()->id;
            $data->save();

            WorkerCity::where('worker_id', $id)->delete();

            $data = collect($request->city)->map(function($item, $key) use($id) {
                return [
                    'worker_id' => $id,
                    'city_id' => $item
                ];
            });
            WorkerCity::insert($data->toArray());
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
