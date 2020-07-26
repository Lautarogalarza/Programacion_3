<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;

class UsuariosController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Usuario::all());

        $response->getBody()->write($rta);
        return $response;
    }

    public function add(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        var_dump($body);
        $usuario = new Usuario;
        $usuario->nombre = $body["nombre"];
        $usuario->clave = $body["clave"];
        $usuario->tipo = $body["tipo"];

        $rta = json_encode(array("ok" => $usuario->save()));

        $response->getBody()->write($rta);
        return $response;
    }
    
    public function login(Request $request, Response $response, $args)
    {
        $array = getAll();
        var_dump($array);
    }
}