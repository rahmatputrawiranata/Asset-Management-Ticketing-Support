<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() {
        return view('admin.customer.index');
    }

    public function data() {
        return datatables()
                ->of(Customer::all())
                ->addIndexColumn()
                ->addColumn('branch', function (Customer $q) {
                    return $q->branch->name;
                })
                ->editColumn('status', function (Customer $q) {
                    return $q->status == 1 ? 'active' : 'inactive';
                })
                ->make();
    }
}
