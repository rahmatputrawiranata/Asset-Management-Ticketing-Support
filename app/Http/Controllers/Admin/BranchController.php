<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index() {
        return view('admin.branch.index');
    }

    public function data() {

        return datatables()
                ->eloquent(Branch::query())
                ->addIndexColumn()
                ->addColumn('country_nmae', function(Branch $q) {
                    return $q->city->region->country->name;
                })
                ->addColumn('countries_id', function(Branch $q){
                    return $q->city->region->country->id;
                })
                ->addColumn('province', function(Branch $q) {
                    return $q->city->region->name;
                })
                ->addColumn('province_id', function(Branch $q) {
                    return $q->city->region->id;
                })
                ->addColumn('city', function(Branch $q) {
                    return $q->city->name;
                })
                ->addColumn('city_id', function(Branch $q) {
                    return $q->city->id;
                })
                ->toJson();
    }

}
