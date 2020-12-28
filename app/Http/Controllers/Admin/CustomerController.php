<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        return view('admin.customer.index');
    }

    public function data() {
        return datatables()
                ->of(Customer::all())
                ->addIndexColumn()
                ->make();
    }
}
