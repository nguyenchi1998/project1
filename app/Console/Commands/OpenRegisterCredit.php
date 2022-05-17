<?php

namespace App\Console\Commands;

use App\Repositories\IClassRoomRepository;
use App\Repositories\IStudentRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OpenRegisterCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:open';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open register for credit';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $classRepository;
    protected $studentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->classRepository = app(IClassRoomRepository::class);
        $this->studentRepository = app(IStudentRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    }
}
