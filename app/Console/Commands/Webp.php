<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Webp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webp:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '画像をwebpに変換';

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
        exec('./webp.sh');
    }
}
