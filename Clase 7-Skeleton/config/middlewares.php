<?php

use Slim\App;
use App\Middleware\BeforeMiddleware;
use App\Middleware\AfterMiddleware;


return function (App $app) {
    $app->addBodyParsingMiddleware();

     $app->add(new BeforeMiddleware());//se ejecuta antes de ir a la ruta
    $app->add(new AfterMiddleware()); //se ejecuta despues de ir a la ruta
    // $app->add(BeforeMiddleware::class);
    
};

?>