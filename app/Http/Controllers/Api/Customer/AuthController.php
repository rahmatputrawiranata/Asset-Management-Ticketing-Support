<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:customer')->except('login');
    }

    protected function jwt(Customer $customer) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $customer, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    protected function respondWithToken($token)
    {
        return $this->respondSuccess(
            'Success!!',
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ]
        );
    }

    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // $type = 'username';

        // if(!$customer = Customer::where($type, $request->username)->first()) {
        //     return $this->respondFail('Email, Phone Number or Username not registered', [], 401);
        // }

        // if(!Hash::check($request->password, $customer->password)) {
        //     return $this->respondFail('Username and Password combination is Invalid', [], 401);
        // }

        // return $this->respondSuccess('Success', [
        //     'token' => $this->jwt($customer)
        // ]);

        $credentials = $request->only(['username', 'password']);

        if(!$token = Auth::attempt($credentials)) {
            return $this->respondFail();
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request) {
        // $this->validate($request, [
        //     'username' => 'required|unique:customers,username',
        //     'full_name' => 'required',
        //     'phone' => 'required|unique:customers,phone',
        //     'email' => 'required|unique:customers,email',
        //     'password' => 'required|min:8|max:18',
        //     'c_password' => 'same:password'
        // ]);

        DB::beginTransaction();
        try {
            $model = new Customer();
            $model->full_name = $request->full_name;
            $model->username = $request->username;
            $model->branch_id = $request->branch;
            $model->phone = $request->phone;
            $model->email = $request->email;
            $model->password = Hash::make($request->password);
            $model->branch_id = $request->branch_id;
            $model->user = $request->header('user-agent');
            $model->save();
        }catch(Exception $e) {
            DB::rollback();
            return $this->respondFail();
        }

        DB::commit();

        return $this->respondSuccess();

    }
}
