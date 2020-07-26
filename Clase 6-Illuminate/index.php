<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require './config/capsule.php';
require './models/alumno.php';

$app = AppFactory::create();

 $app->addErrorMiddleware(true, true, true);

$app->setBasePath('/programacion3/Clase 6-Illuminate');

$app->get('/', function (Request $request, Response $response, array $args) {

   // $users = Capsule::table('alumnos')->get();//trae todos los elementos de la tabla

   // $users = Capsule::table('alumnos')->where('legajo', '>', 1888)->get();//trae todos los elementos de la tabla donde el legajo sea mayor a 1888

    $users = Capsule::table('alumnos')->where('legajo', '>', 1888)->value('legajo');//trae todos el legajo de la tabla donde el legajo sea mayor a 1888
    
    $response->getBody()->write(json_encode($users));


    return $response->withHeader('Content-Type','application/json');
});

$app->get('/join', function (Request $request, Response $response) {
  
 
     $users = Capsule::table('alumnos')->where('legajo', '>', 1888)->value('legajo');//trae todos el legajo de la tabla donde el legajo sea mayor a 1888
     
     $response->getBody()->write(json_encode($users));
 
 
     return $response->withHeader('Content-Type','application/json');
 });




$app->get('/schema', function (Request $request, Response $response, array $args) {

    $schema=Capsule::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('email')->unique();
        $table->timestamps();
    });
    
    $response->getBody()->write(json_encode($schema));

    return $response->withHeader('Content-Type','application/json');
 });








 $app->get('/alumno', function (Request $request, Response $response, array $args) {

    $alumnos=Alumno::get();//trabajo directamente con la tabla de esta forma

   $alumno = new Alumno();

   $alumno->nombre="jon";
   $alumno->legajo=6666;
   $alumno->localidad=1;
   
    
    $response->getBody()->write(json_encode($alumno->save()));//guardo el elemento en la db con sus timestamps

    return $response->withHeader('Content-Type','application/json');
 });


 $app->get('/alumnos', function (Request $request, Response $response, array $args) {

    $alumnos=Alumno::get();//trabajo directamente con la tabla de esta forma

    //$alumnos=Alumno::find(1);//busca una columna por el valor de su primary key, puede recibir un array
 
    $response->getBody()->write(json_encode($alumnos));//guardo el elemento en la db con sus timestamps

    return $response->withHeader('Content-Type','application/json');
 });

 $app->get('/alumnosUpdate', function (Request $request, Response $response, array $args) {

    $alumnos=Alumno::find(1);

    $alumnos->nombre="lauti";

    $response->getBody()->write(json_encode($alumnos->save()));//tambien puede actualizar

    return $response->withHeader('Content-Type','application/json');
 });

 $app->get('/alumnosDelete', function (Request $request, Response $response, array $args) {

    $alumnos=Alumno::find(5);

    $response->getBody()->write(json_encode($alumnos->delete()));//tambien puede actualizar

    return $response->withHeader('Content-Type','application/json');
 });




 

$app->run(); 


?>