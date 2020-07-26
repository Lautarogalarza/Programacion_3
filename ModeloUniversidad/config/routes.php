<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;

return function ($app)
{
    $app->group('/usuarios', function (RouteCollectorProxy $group)
    {
        $group->get('[/]', UsuariosController::class . ':getAll');
        $group->post('[/]', UsuariosController::class . ':add');
    });

    $app->group('/login', function (RouteCollectorProxy $group)
    {
        $group->post('[/]', UsuariosController::class . ':login');
    });
};