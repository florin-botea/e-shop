<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Remigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remigrate {m}';

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
     * @return mixed
     */
    public function handle()
    {
        $m = $this->argument('m');
        
        foreach (glob(base_path('database/migrations/*')) as $file) {
            if (! strpos($file, $m)) continue;
            $tmp = explode('/', $file);
            $m = end($tmp);

            $this->call('migrate:refresh', [
                '--path' => '/database/migrations/' . $m
            ]);
        }
    }
}
