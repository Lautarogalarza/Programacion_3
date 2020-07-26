<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Config\Database;

//Instancia de illuminate
new Database();

$app = AppFactory::create();
$app->setBasePath("/ModeloUniversidad/public");

//REGISTRAR RUTAS
(require_once __DIR__ . './routes.php')($app);

//REGISTRAR MIDDLEWARE
(require_once __DIR__ . './middlewares.php')($app);

return $app;