<?php

namespace App\Console\Commands;

use App\Services\CommonService;
use Illuminate\Console\Command;

class LlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'll
                            {prefix}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '列举相同前缀的命令';

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
        $prefix = $this->argument('prefix');

        $commands = CommonService::listKeyCommands($prefix.":");

        $width = CommonService::getColumnWidth($commands);

        $this->comment('');

        /** @var Command $command */
        foreach ($commands as $command) {
            $this->line(sprintf(" %-{$width}s %s", $command->getName(), $command->getDescription()));
        }
    }
}
