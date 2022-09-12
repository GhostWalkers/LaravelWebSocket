<?php

namespace Ghostwalker\Commands;

use App\Models\User;
use App\Support\DripEmailer;
use Ghostwalker\LaravelWebsocket;
use Illuminate\Console\Command;
use ReflectionException;
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
     * @var LaravelWebsocket
     */
    protected LaravelWebsocket $laravelWebSocket;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Booting all websocket in your folder';

    public function __construct()
    {
        parent::__construct();
        $this->laravelWebSocket = new LaravelWebsocket();
    }

    /**
     * @throws ReflectionException
     */
    public function handle()
    {
        $this->laravelWebSocket->bootStrap();
        LaravelWebsocket::$app->run();
    }
}
