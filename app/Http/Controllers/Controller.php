<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createSelectDataFormat(object $data,string $id_variable,string $title_variable) {
        return collect($data)->map(function ($q) use($id_variable, $title_variable) {
            return [
                'value' => $q->$id_variable,
                'title' => $q->$title_variable
            ];
        })->all();
    }
}
