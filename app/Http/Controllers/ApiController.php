<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected function createResponse($message = 'Success', $data = [], $header = [], $status_code = 200, $fail = true) {
        return response()->json([
            'status' => $fail ? 'success' : 'error',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ],200);
    }

    public function respondSuccess($message = 'Success!!', $data = [], $header = []) {
        return $this->createResponse($message, $data, $header);
    }

    public function respondFail($message = 'Error!!', $data = [], $status_code = 500, $header = []) {
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
}
