<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\ReginKey;

class ListReginKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reginkey:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Unused ReginKeys';

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
        $headers = ['id', 'regin_key', 'status', 'user_id', 'usetime'];
        $regin_keys = ReginKey::where('status', 0)->get();
        if($regin_keys->isEmpty()){
            $this->line('There is no free regin key now.');
        } else {
            $this->table($headers, $regin_keys);
        }
    }
}
