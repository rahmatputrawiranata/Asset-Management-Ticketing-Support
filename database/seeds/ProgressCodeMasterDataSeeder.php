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

        MasterData::where('type', 'report_progress')->truncate();

        $data = array(
            [
                'type' => 'report_progress',
                'key' => 'report_progress_start',
                'value_type' => 'string',
                'value' => 'Report tickets are generated'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_validation_by_Admin',
                'value_type' => 'string',
                'value' => 'Validation problems or damage by Admin Service'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_system_deploy_worker',
                'value_type' => 'string',
                'value' => 'The system is looking for a technician'
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_technician_found',
                'value_type' => 'string',
                'value' => 'Technician found, estimated time to location at '
            ],
            [
                'type' => 'report_progress',
                'key' => 'report_progress_done',
                'value_type' => 'string',
                'value' => 'Report ticket is close'
            ],
        );

        MasterData::insert($data);
    }
}
