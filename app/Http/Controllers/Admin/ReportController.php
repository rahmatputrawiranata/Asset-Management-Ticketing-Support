<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportProgress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index() {
        return view('admin.report.index');
    }

    public function data() {
        $model = Report::orderByDesc('created_at');

        return datatables()
                ->eloquent($model)
                ->addColumn('item_problem', function($q){
                    if($q->kind_of_damage_type_id){
                        return $q->kindOfDamageType->name;
                    }
                    return '';
                })
                ->addColumn('problem_detail', function($q){
                    if($q->kind_of_damage_type_id){
                        return $q->kindOfDamageType->item->name;
                    }
                    return '';
                })
                ->addColumn('category_problem_detail', function($q){
                    if($q->kind_of_damage_type_id){
                        return $q->kindOfDamageType->category;
                    }
                    return '';
                })
                ->addColumn('severity', function($q){
                    if($q->kind_of_damage_type_id){
                        return $q->kindOfDamageType->severity->name;
                    }
                    return '';
                })
                ->addColumn('time_limit', function($q){
                    if($q->kind_of_damage_type_id){
                        if($q->kindOfDamageType->category === 'hardware'){
                            if($q->branch->city->is_fast_service ===1){
                                return 1440;
                            }else{
                                return $q->kindOfDamageType->severity->hardware_time;
                            }
                        }else{
                            return $q->kindOfDamageType->severity->software_time;
                        }
                    }
                    return '';
                })
                ->addColumn('city', function($q) {
                    return $q->branch->city->name;
                })
                ->addColumn('branch', function($q) {
                    return $q->branch->name;
                })
                ->addColumn('status', function($q) {
                    return $q->getReportProgressActiveAttribute()->value;
                })
                ->addColumn('status_value', function($q) {
                    return $q->getReportProgressActiveAttribute()->key;
                })
                ->make();
    }

    public function update(Request $request) {

        DB::beginTransaction();
        try{
            $model = Report::find($request->id);

            $model->kind_of_damage_type_id = $request->kind_of_damage_type_id ?? $model->kind_of_damage_type_id;
            $model->report_notes = $request->report_notes ?? $model->report_notes;
            $model->save();
            ReportProgress::where('report_id', $model->id)->update(['status' => 2]);

            if($request->progress_code === 'report_progress_validation_by_Admin') {



                if($request->notes){
                    $notes = json_encode(array(
                        'author' => 'admin',
                        'data' => $request->notes,
                    ));
                }

                $rProgress = new ReportProgress();
                $rProgress->report_id = $model->id;
                $rProgress->progress_code = $request->progress_code;
                $rProgress->descriptions = $request->descriptions;
                $rProgress->notes = $request->resolution === 'report_progress_system_deploy_worker' ? $notes : '';
                $rProgress->user = 1;
                $rProgress->status = 2;
                $rProgress->save();

                $rProgress2 = new ReportProgress();
                $rProgress2->report_id = $model->id;
                $rProgress2->progress_code = $request->resolution;
                // $rProgress->descriptions = $request->descriptions;
                $rProgress2->notes = $request->resolution === 'report_progress_done' ? $notes : '';
                $rProgress2->user = 1;
                $rProgress2->status = 1;
                $rProgress2->save();
            }

            if($request->progress_code === 'report_progress_system_deploy_worker'){


                if($request->notes){
                    $notes = json_encode(array(
                        'author' => 'admin',
                        'data' => $request->notes,
                    ));
                }

                $rProgress = new ReportProgress();
                $rProgress->report_id = $model->id;
                $rProgress->progress_code = $request->resolution;
                $rProgress->descriptions = $request->descriptions;
                $rProgress->notes = $notes;
                $rProgress->user = 1;
                $rProgress->save();
            }


        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }

        DB::commit();
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Successfully update data',
            'data' => []
        ]);

    }
}
