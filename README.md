# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ghostwalker/laravel websocket.svg?style=flat-square)](https://packagist.org/packages/ghostwalker/laravel websocket)
[![Total Downloads](https://img.shields.io/packagist/dt/ghostwalker/laravel websocket.svg?style=flat-square)](https://packagist.org/packages/ghostwalker/laravel websocket)
![GitHub Actions](https://github.com/ghostwalker/laravel websocket/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

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

then write full path to you socket folder in .env

example: 

```dotenv
    SOCKETS_DIR=/var/www/example/sockets
    SOCKETS_HTTPHOST="localhost"
    SOCKETS_PORT="8080"
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

