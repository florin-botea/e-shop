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

function get_dir_contents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            get_dir_contents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

$parts = preg_split('~[/\?]~', trim($_SERVER['REQUEST_URI'] ?? '', '/'));
if ($parts[0] == 'admin') {
    $app = require __DIR__.'/../admin/index.php';
} else {
    $app = require __DIR__.'/../admin/index.php';
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
