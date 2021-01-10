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
use Illuminate\Support\Str;

class AuthController extends ApiController
{

    public function __construct()
    {
        // $this->middleware('auth:customer')->except('login');
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
                'access_token' => $token
            ]
        );
    }

    public function login(Request $request) {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $type = 'username';

        if(is_numeric($request->username)){
            $type = 'phone';
        }else if(filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
        }else {
            $type = 'username';
        }

        if($type == 'phone') {
            $request->merge([
                'username' => $this->generatePhone($request->username),
            ]);
        }

        $credentials = array(
            $type => $request->username,
            'password' => $request->password
        );

        if(!$token = Auth::attempt($credentials)) {
            return $this->respondFail(
                'invalid username or password',
                [],
                401
            );
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request) {
        $request->merge([
            'phone' => $this->generatePhone($request->phone),
            'username' => Str::lower($request->username),
            'email' => Str::lower($request->email),
        ]);
        $this->validate($request, [
            'username' => 'required|unique:customers,username',
            'full_name' => 'required',
            'phone' => 'required|unique:customers,phone',
            'email' => 'required|unique:customers,email',
            'password' => 'required|min:8|max:18',
            'c_password' => 'same:password',
            'branch_id' => 'required|integer',
        ]);

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
            return $this->respondFail(
                $e->getMessage()
            );
        }

        DB::commit();

        $token = Auth::attempt(['email' => $model->email, 'password' => $request->password]);

        return $this->respondWithToken($token);

    }
}
