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
        $model = Report::orderByDesc('created_at');

        return datatables()
                ->eloquent($model)
                ->addColumn('city', function($q) {
                    $data = $q->branch->city->withTrashed();
                    return $data->name;
                })
                ->addColumn('branch', function($q) {
                    $data = $q->branch->withTrashed();
                    return $data->name;
                })
                ->addColumn('status', function($q) {
                    return $q->statusProgress;
                })
                ->make();
    }
}
