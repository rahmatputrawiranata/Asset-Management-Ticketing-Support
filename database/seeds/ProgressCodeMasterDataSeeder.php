<?php

use App\Models\MasterData;
use Illuminate\Database\Seeder;

class ProgressCodeMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'type' => 'report_progress',
                'key' => 'report_progress_start',
                'value_type' => 'string',
                'value' => 'Report Start'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_customer_service_start_contact_customer',
                'value_type' => 'string',
                'value' => 'Customer Service Start Contact Customer'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_customer_service_finish_contact_customer',
                'value_type' => 'string',
                'value' => 'Customer Service Finish Contact Customer',
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_system_deploy_worker',
                'value_type' => 'string',
                'value' => 'System Find and Deploy Worker to Customer'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_system_failed_deploy_worker',
                'value_type' => 'string',
                'value' => 'System Failed Deploy Worker Please Wait Until Admin Assign New Worker',
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_worker_report_finising_job',
                'value_type' => 'string',
                'value' => 'Worker Report Job is Finished'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_done',
                'value_type' => 'string',
                'value' => 'job is Finished'
            ]
        );

        MasterData::insert($data);
    }
}
