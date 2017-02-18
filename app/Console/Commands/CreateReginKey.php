<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\ReginKey;

class CreateReginKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reginkey:create {ll?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Regin Key.';

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
        $length = (int)$this->argument('ll');
        $length = $length ? $length : 5;
        $exist = false;
        do {
            $key = strtolower(str_random($length));
            $regin_key = ReginKey::where('regin_key', $key)->get();
            $exist = !$regin_key->isEmpty();
        } while ($exist);
        $new_regin_key = new ReginKey;
        $new_regin_key->regin_key = $key;
        $new_regin_key->save();
        $this->line('The key is: '.$key);
    }
}
