<?php
require_once './persona.php';
require_once './response.php';

$method= $_SERVER["REQUEST_METHOD"];
$path=  $_SERVER["PATH_INFO"]??"ruta inexistente";

$response= new Response();
switch ($path) {
    case '/persona':
        switch ($method) {
            case 'GET'://Mostrar recursos
                $legajo = $_GET['legajo'] ?? 0;

                if ($legajo == 0) {
                    $rta = Persona::find();
                } else {
                    $rta = Persona::find($legajo);
                }

                $response->data = $rta;


              echo json_encode($response);
               
                break;
             case 'POST'://Guardar o modificar recursos
                $nombre=$_POST["nombre"]??null;
                $apellido=$_POST["apellido"]??null;
                $legajo=$_POST["legajo"]??null;
                if (isset($nombre)&&isset($apellido)&&isset($legajo)) {
                    $persona = new Persona($nombre,$apellido,$legajo);

                    $rta=$persona->Save();

                    $response->data = $rta;
        
                }
                else{
                    $response->data = "faltan datos";
                    $response->status = "failed";

                }

                echo json_encode($response);

                 break;
                 
            default:
                echo "Metodo no soportado";
                break;
        }
        break;
    case '/alumno':
        switch ($method) {
            case 'GET':
                
                break;
             case 'POST':
                
                 break;
            default:
                echo "Metodo no soportado";
                break;
        }
         break;
    
    default:
        # code...
        break;
}



?>