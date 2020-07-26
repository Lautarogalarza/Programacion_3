<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnosController;
use App\Middleware\BeforeMiddleware;



return function ($app) {
    $app->group('/alumnos', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':add');
        $group->put('/:id', AlumnosController::class . ':getAll');
        $group->delete('/:id', AlumnosController::class . ':getAll');
    });

    $app->group('/materias', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':getAll');
        $group->put('/:id', AlumnosController::class . ':getAll');
        $group->delete('/:id', AlumnosController::class . ':getAll');
    });
};