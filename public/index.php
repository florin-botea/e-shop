<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

// todo remove and put as package
require_once('./../packages/lumencart/framework/src/helpers.php');

$parts = preg_split('~[/\?]~', trim($_SERVER['REQUEST_URI'] ?? '', '/'));
if ($parts[0] == 'admin') {
    $app = require __DIR__.'/../bootstrap/admin.php';
} else {
    $app = require __DIR__.'/../bootstrap/catalog.php';
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$app->run();
