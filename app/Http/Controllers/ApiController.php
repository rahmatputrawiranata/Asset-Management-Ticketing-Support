<?php

namespace App\Http\Controllers;

use App\Exceptions\RestApiValidationErrorException;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected function createResponse($message = 'Success', $data = [], $header = [], $status_code = 200, $fail = true) {
        return response()->json([
            'status' => $fail ? 'success' : 'error',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ],$status_code);
    }

    public function generatePhone($phone) {
        $res = $phone;
        if(substr($res, 0,3) == '+62') {
            $res = str_replace('+62', '62', $res);
        }

        if(!empty($res[0]) && $res[0] == '0') {
            $res = substr_replace($res, '62', 0, 1);
        }

        if(substr($res, 0, 2) != '62') {
            $res = '62'.$res;
        }

        return $res;
    }

    public function respondSuccess($message = 'Success!!', $data = [], $header = []) {
        return $this->createResponse($message, $data, $header);
    }

    public function respondFail($message = 'Error!!', $data = [], $status_code = 400, $header = []) {
        return $this->createResponse($message, $data, [], $status_code, false);
    }

    public function createSelectDataFormat(object $data,string $id_variable,string $title_variable) {
        return collect($data)->map(function ($q) use($id_variable, $title_variable) {
            return [
                'value' => $q->$id_variable,
                'title' => $q->$title_variable
            ];
        })->all();
    }

    public function validate(Request $request, Array $rules, Array $message = [], Array $customAttributes = []) {
        $validation = app('validator')->make($request->all(), $rules, $message);

        if($validation->fails()) $this->throwRestValidationError($validation->errors()->all(), $validation->errors()->first());

        return true;
    }

    public function throwRestValidationError(Array $errors, $message) {
        $error = [
            'status_code' => 422,
            'status' => 'error',
            'message' => $message,
            'data' => $errors
        ];

        throw new RestApiValidationErrorException($error, $message);
    }
}
