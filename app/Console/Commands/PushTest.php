<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Notifications\NewsPush;

use App\User;

class PushTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webpush:test';

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
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new NewsPush);
        }
    }
}
