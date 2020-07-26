<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();//crea el servidor

 $app->addErrorMiddleware(true, true, true);//detalles del error

$app->setBasePath('/programacion3/Clase 5-Slim');//marca la ruta encadenada

$app->get('/persona/{id}', function (Request $request, Response $response, array $args) {//acceso al metodo http

    $queryString =$request->getQueryParams();//trae los elementos de los parametros en el postman

   // $headers = $request->getHeaders();//trae todos los elementos del header

    $headers = $request->getHeader("host"); //trae los elementos seleccionados del header


    $rta = array( "Succes"=> true, 
    "Data"=> $args, 
    "Query"=> $queryString, 
    "Headers"=>$headers);

    $rtaJson = json_encode($rta);

    $response->getBody()->write($rtaJson);

    return $response->withHeader('Content-Type','application/json');//parsea la respuesta completamenta a json
});

$app->get('/persona[/]', function (Request $request, Response $response, array $args) {//acceso al metodo http,parametro opcional barra
    

    $queryString =$request->getQueryParams();//trae los elementos de los parametros en el postman

   // $headers = $request->getHeaders();//trae todos los elementos del header

    $headers = $request->getHeader("host"); //trae los elementos seleccionados del header


    $rta = array( "Succes"=> true, 
    "Data"=> $args, 
    "Query"=> $queryString, 
    "Headers"=>$headers);

    $rtaJson = json_encode($rta);

    $response->getBody()->write($rtaJson);

    return $response->withHeader('Content-Type','application/json');//parsea la respuesta completamenta a json
});

$app->post('/persona', function (Request $request, Response $response) {

    $body = $request->getParsedBody();

    $files = $_FILES;//$request->getUploadedFiles();

    $rta = array( "Succes"=> true, 
    "Data"=> "POST",
    "Body"=> $body,
    "Files"=> $files["Foto"] 
   );


    $rtaJson = json_encode($rta);

    $response->getBody()->write($rtaJson);

    return $response->withHeader('Content-Type','application/json');//parsea la respuesta completamenta a json
});


$app->put('/persona', function (Request $request, Response $response) {


    $response->getBody()->write("PUT");

    return $response->withHeader('Content-Type','application/json');//parsea la respuesta completamenta a json
});

$app->delete('/persona', function (Request $request, Response $response) {


    $response->getBody()->write("DELETE");

    return $response->withHeader('Content-Type','application/json');//parsea la respuesta completamenta a json
});


$app->group('/Alumno', function($group){//agrupacion de la misma ruta en un grupo

    $group->get('/{id}',function (Request $request, Response $response){

    $response->getBody()->write("alumno/{id}");

    return $response->withHeader('Content-Type','application/json');

     });

     $group->get('[/]',function (Request $request, Response $response){

        $response->getBody()->write("alumno[/]");
    
        return $response->withHeader('Content-Type','application/json');
    
         });


        });





$app->run(); //levanta el servidor


?>