<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CPClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cpclient:exec {type} {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nice CPClient';

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
        $type = $this->argument('type');
        $sitecode = config('checkplus.site_code');
        $sitepw = config('checkplus.site_pw');
        $data = $this->argument('data');
        $client = app_path()."/NICE/CPClient_64bit";
        if ($type == 'SEQ') {
            $params = "{$type} {$sitecode}";
        }else{
            $params = "{$type} {$sitecode} {$sitepw} {$data}";
        }
        exec("{$client} {$params}", $output, $return);
        $this->output->write(implode('',$output), false);

        return 0;
    }
}
