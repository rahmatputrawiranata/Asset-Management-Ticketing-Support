<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use App\Models\Customer;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JWTCustomerMiddleware extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->header('authorization');
        if(!$token) {
            return $this->respondFail('Unauthicated !!', [], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        // dd($token);

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        }catch(ExpiredException $e) {
            return $this->respondFail('Provided Token is Expired', [], 400);
        }catch(Exception $e) {
            return $this->respondFail($e->getMessage(), [], 400);
        }

        $user = Customer::where([
            'id' => $credentials->sub->id,
            'username' => $credentials->sub->username,
            'email' => $credentials->sub->email,
            'phone' => $credentials->sub->phone
        ])->first();

        if(!$user) {
            return $this->respondFail('Unauthicated !!', [], 401);
        }
        return $next($request);
    }
}
