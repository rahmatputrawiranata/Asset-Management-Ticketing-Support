<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function createSelectDataFormat(object $data,string $id_variable,string $title_variable) {
        return collect($data)->map(function ($q) use($id_variable, $title_variable) {
            return [
                'value' => $q->$id_variable,
                'title' => $q->$title_variable
            ];
        })->all();
    }
}
