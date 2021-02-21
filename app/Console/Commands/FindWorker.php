<?php

namespace App\Console\Commands;

use App\Models\Report;
use Illuminate\Console\Command;

class FindWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $console = new \Symfony\Component\Console\Output\ConsoleOutput();
        $report = Report::query()
                    ->join('report_progress', 'reports.id', '=', 'report_progress.report_id')
                    ->join('branches', 'reports.branch_id', '=', 'branches.id')
                    ->where('report_progress.progress_code', 'report_progress_system_deploy_worker')
                    ->where('report_progress.status', 1)
                    ->get();

        foreach($report as $row){
            $console->writeln($row);
        }
    }
}
