<?php

namespace App\Console\Commands;

use App\Repositories\ScheduleRepository;
use Illuminate\Console\Command;

class StartSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'class_credit:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start class credit';

    protected $scheduleRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->scheduleRepository = app(ScheduleRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->scheduleRepository->model()->whereStatus(0)->update([
            'status' => 3
        ]);
    }
}
