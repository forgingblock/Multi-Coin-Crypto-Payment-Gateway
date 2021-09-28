<?php

try {


    dibi::connect([
        'driver'   => Config::get('mysql:driver'),
        'host'     => Config::get('mysql:hostname'),
        'username' => Config::get('mysql:username'),
        'password' => Config::get('mysql:password'),
        'database' => Config::get('mysql:database'),
        'options' => [
            MYSQLI_OPT_CONNECT_TIMEOUT => 30,
        ],
        'flags' => MYSQLI_CLIENT_COMPRESS,
    ]);


} catch (Dibi\Exception $e) {
    echo get_class($e), ': ', $e->getMessage(), "\n";
}