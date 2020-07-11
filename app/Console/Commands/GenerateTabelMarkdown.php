<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GenerateTabelMarkdown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'czz:table_doc
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '根据表名，生成表描述Markdown';

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
     * @return mixed
     */
    public function handle()
    {
        //$table_name = $this->ask('请输入表名：');
        try {
            $databaes = 'blueprint';
            $tables = DB::select('SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema= ?', [$databaes]);

            foreach ($tables as $v) {
                $table_name = $v->TABLE_NAME;
                $res = DB::select('SELECT COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME = ? ', [$table_name]);
                $doc = $this->fieldDesc($res);
                Storage::put('./'.$table_name.'.md', $doc);
                $this->info("生成文档成功：".$table_name.'.md');
            }
        } catch (\Throwable $e) {
            $this->warn($e->getMessage());
        }
    }

    protected function fieldDesc($data)
    {
        $str = '| 字段 | 说明 |'."\r\n";
        $str .= '| ----| ---- |'."\r\n";

        foreach ($data as $v) {
            $v = (array)$v;
            $str .= '|'.$v['COLUMN_NAME'].'|'.$v['COLUMN_COMMENT'].'|'."\r\n";
        }

        return $str;
    }
}
