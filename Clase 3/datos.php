<?php

class Datos{

public static function Guardar($archivo,$datos,$formato)
{
    $file=fopen($archivo,$formato);

    $rta=fwrite($file,$datos);

    fclose($file);

    return $rta;

}

public static function GuardarJSON($archivo,$objeto)
{
   
    $arrayJSON = Datos::LeerJSON($archivo,$objeto);

    array_push($arrayJSON,$objeto);

    $rta =Datos::Guardar($archivo,json_encode($arrayJSON),"w");

    return $rta;

}

public static function LeerJSON($archivo)
{
    $file=fopen($archivo,"r");

    $arrayString = fread($file,filesize($archivo));

    $arrayJSON = json_decode($arrayString);


    fclose($file);

    return$arrayJSON;

}

public static function LeerTodo($archivo)
{
    $file=fopen($archivo,"r");
    $lista=array();

   while (!feof($file)) {
       $linea = fgets($file);

       if ($linea!="") {
           $explode= explode("@",$linea);
           if (count($explode)>0) {
            array_push($lista,$explode);
        }
    }
    
}
      

    fclose($file);

    return $lista;

}


}

?>