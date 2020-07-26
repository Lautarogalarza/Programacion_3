<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Alumno;

class AlumnosController{

    public function getAll(Request $request, Response $response, $args){

        $rta = json_encode(Alumno::all());

         $response->getBody()->write( $rta);
  
         return $response;//parsea la respuesta completamenta a json

    }

    public function add(Request $request, Response $response, $args){


        $alumno = new Alumno();

        $alumno->nombre="eloquent";
        $alumno->legajo=4321;
        $alumno->localidad=3;
        $alumno->cuatrimestr=1;

        $rta = json_encode(array("OK"=>$alumno->save()));

         //$response->getBody()->write( $rta);

         $response->getBody()->write( $rta);
        
         return $response;//parsea la respuesta completamenta a json

    }
}



?>