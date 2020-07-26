<?php

require __DIR__ . '/../vendor/autoload.php';
use Slim\Factory\AppFactory;
use Config\Database;

//instanciar illuminate
new Database();
$app = AppFactory::create();
$app->setBasePath("/programacion3/Clase 7-Skeleton/public");

//REGISTRAR RUTAS
(require __DIR__ .'/routes.php')($app);//llamo a la funcion de ruts y le paso el parametro

// REGISTRAR MIDDLEWARE
(require_once __DIR__ . '/middlewares.php')($app);


return $app;//creo el servidor y lo retorno

?>