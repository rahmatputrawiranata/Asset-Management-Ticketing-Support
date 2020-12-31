<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        return view('admin.report.index');
    }

    public function data() {
        $model = Report::query();

        return datatables()
                ->eloquent($model)
                ->addIndexColumn()
                ->make();
    }
}
