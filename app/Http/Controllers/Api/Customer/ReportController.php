<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Report;
use App\Models\ReportProgress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends ApiController
{

    // function for finding device base barcode
    public function findDevice(Request $request) {
        $this->validate($request, [
            'device_code' => 'required|exists:devices,device_code'
        ]);

        if(!$model = Device::where('device_code', $request->device_code)->first()) {
            return $this->respondFail('Device Not Found!!');
        }

        return $this->respondSuccess('success', $model);
    }

    //get all error is affiliate to device
    public function getAffiliateErrorFromDevice(Request $request) {
        $this->validate($request, [
            'device_code' => 'required|exists:devices,device_code'
        ]);


    }

    // create report to admin
    public function createReport(Request $request) {
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
            $rProgress->progress_code = 'report_progress_start';
            $rProgress->status = 1;
            $rProgress->user = $user->id;
            $rProgress->save();



        }catch(Exception $e) {
            DB::rollback();
            return $this->respondFail($e->getMessage());
        }
        DB::commit();
        return $this->respondSuccess();

    }

    public function all(Request $request) {
        $this->validate($request, [
            'limit' => 'nullable|integer'
        ]);

        $limit = $request->input('limit', 10);

        $user = Auth::user();

        $model = Report::query()
                    ->where('customer_id', $user->id)
                    ->with(['branch', 'reportProgress.masterData', 'worker'])
                    ->orderBy('created_at')
                    ->paginate($limit);

        return $this->respondSuccess('Success!!', $model);

    }
}
