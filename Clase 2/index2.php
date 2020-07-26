<?php


//$id=$_GET["id"]??0;//si el id existe y es distinto de nulo muestra el valor, sino es 0,

/*if(isset($_GET["id"]))
{
    echo "Metodo GET". $_GET["id"];
    
}
else {
    echo "POST";
}*/

//echo $id;


$request_method = $_SERVER["REQUEST_METHOD"];
$path_info = $_SERVER["PATH_INFO"];
$datos="";


switch ($path_info) {
    case '/mascotas':
        
        if ($request_method=="POST") {
            echo "POST";
            $archivo=fopen("mascotas.txt","a+");
            $linea=$_POST["nombre"].",".$_POST["apellido"].PHP_EOL;
            $bytes = fwrite($archivo,$linea);
            $datos=$linea;
            $cerrar=fclose($archivo);
        }
        elseif ($request_method=="GET") {
            echo "GET";
            $archivo=fopen("mascotas.txt","a+");
            $datos=fread($archivo,filesize("mascotas.txt"));
        
            $cerrar=fclose($archivo);
        }
        else
        {
            echo "405 method not allowed";
        }
        
        break;

    case '/personas':
        if ($request_method=="POST") {
            echo "POST";
        }
        elseif ($request_method=="GET") {
            $datos=array("juan","maria","pepe");
        }
        else
        {
            echo "405 method not allowed";
        }
         break;
            
    case '/autos':
        if ($request_method=="POST") {
            echo "POST";
        }
        elseif ($request_method=="GET") {
            $datos=array("ford","fiat","ferrari");
        }
        else
        {
            echo "405 method not allowed";
        }
        break;
    
    default:
        # code...
        break;
}

$respuesta = new stdClass;
$respuesta->succes = true;
$respuesta->data= $datos;

echo json_encode($respuesta);



?>