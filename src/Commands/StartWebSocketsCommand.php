<?php

namespace Ghostwalker\Commands;

use App\Models\User;
use App\Support\DripEmailer;
use Ghostwalker\LaravelWebsocket;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

class StartWebSocketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Booting all websocket in your folder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        LaravelWebsocket::bootStrap();
        LaravelWebsocket::$app->run();
    }
}
