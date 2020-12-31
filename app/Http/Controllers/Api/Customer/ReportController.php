<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportProgress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends ApiController
{
    public function create(Request $request) {
        $this->validate($request, [
            'device_id' => 'required|integer',
        ]);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $model = new Report();
            $model->ticket_no = date('Y-m-d').rand(1111, 9999);
            $model->customer_id = $user->id;
            $model->branch_id = $user->branch_id;
            $model->device_id = $request->device_id;
            $model->kind_of_damage_type_id = $request->kind_of_damage_type_id;
            $model->report_notes = $request->report_notes;
            $model->user = $user->id;
            $model->save();

            $rProgress = new ReportProgress();
            $rProgress->report_id = $model->id;
            $rProgress->progress_code = 1;
            $rProgress->status = 1;
            $rProgress->save();

        }catch(Exception $e) {
            DB::rollback();
            return $this->respondFail($e->getMessage());
        }
        DB::commit();
        return $this->respondSuccess();

    }
}
