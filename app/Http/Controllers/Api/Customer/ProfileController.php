<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends ApiController
{

    public function __construct()
    {
        $user = Auth::user();
    }
    public function index() {
        $user = Auth::user();

        $data = Customer::find($user->id);

        return $this->respondSuccess('Success', $data);
    }

    public function update(Request $request) {

        $this->validate($request, [
            'full_name' => 'required|unique:customers,username,except,'.$this->user->id,
            'username' => 'required|unique:customers,username,except,'.$this->user->id,
            'phone' => 'required|unique:customers,phone,except,'.$this->user->id,
            'email' => 'required|email|unique:customers,email,except,'.$this->user->id,
        ]);

        DB::beginTransaction();
        try {
            $model = Customer::find($this->user->id);
            $model->full_name = $request->full_name;
            $model->username = $request->username;
            $model->phone = $request->phone;
            $model->email = $request->email;
            $model->branch_id = $request->branch;
            $model->save();
        }catch(Exception $e){
            DB::rollback();
            return $this->respondFail();
        }

        DB::commit();
        return $this->respondSuccess();
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password'
        ]);

        DB::beginTransaction();
        try{
            $model = Customer::find($this->user->id);
            if(!Hash::check($request->password, $model->password)) {
                throw new Exception('Invalid old password');
            }

            $model->password = Hash::make($request->password);
        }catch(Exception $e) {
            DB::rollback();
            return $this->respondFail($e->getMessage());
        }

        DB::commit();
        return $this->respondSuccess();
    }
}
