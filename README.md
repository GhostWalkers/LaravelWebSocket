
## Installation

You can install the package via composer:

```bash
composer require ghostwalker/laravelwebsocket
```

## Usage

register service-provider

add line to /config/app.php in array "providers"

```php
Ghostwalker\LaravelWebsocketServiceProvider::class
```


.

then publish config

```dotenv
php artisan vendor:publish --provider="Ghostwalker\LaravelWebsocketServiceProvider" --tag="config"
```
.

/config/laravelwebsocket.php

example:

```php
<?php

return [
    'httphost' => 'localhost',
    'port' => 8081,
    'sockets_dir' => 'var/www/html/sockets',
    'artisan_command_start' => 'websocket:start',
];
```
.

Now in this folder you need to create a class that will implement from the MessageComponentInterface and AddRouteContract interfaces

example: 
```php
<?php

namespace Sockets;

use Ghostwalker\Contracts\AddRouteContract;
use Ghostwalker\LaravelWebsocket;
use JetBrains\PhpStorm\Pure;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class mainSocket implements MessageComponentInterface, AddRouteContract
{
    protected \SplObjectStorage $clients;

    #[Pure] public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    public static function addRout(): void
    {
        LaravelWebsocket::$app->route('/chat', new self(), array('*'));
    }
}
```
in the addRout method, you need to change the route of your socket

.

it remains only to start our socket server with the php artisan websocket command
(command to run as a daemon, it will run until the terminal closes. I recommend using screen)

### Modules

you can create an infinite number of classes and all of them will be processed, which allows the system to be flexible

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Ghost Walker](https://github.com/ghostwalker)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

