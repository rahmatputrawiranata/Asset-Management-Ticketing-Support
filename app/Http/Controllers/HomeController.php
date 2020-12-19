<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Worker;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $workers = Worker::where('type', 'internal')->count();

        $outsource = Worker::where('type', 'external')->count();

        $customers = Customer::count();

        $widget = [
            'users' => $users,
            'customers' => $customers,
            'workers' => $workers,
            'outsources' => $outsource
        ];

        return view('admin.dashboard', compact('widget'));
    }
}
