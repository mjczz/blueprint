<?php

namespace App\Console\Commands;

use App\Jobs\Test;
use App\User;
use Illuminate\Console\Command;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '分发任务';

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
        $this->info('分发任务');

        $this->info('');

        Test::dispatch();

        $this->info('success');
    }

}
