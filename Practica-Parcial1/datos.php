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
    $auxArray=array();

    if ($arrayJSON==false) {
       array_push($auxArray,$objeto);
       $rta =Datos::Guardar($archivo,json_encode($auxArray),"w");
    }
    else {
        array_push($arrayJSON,$objeto);

        $rta =Datos::Guardar($archivo,json_encode($arrayJSON),"w");
    }

    return $rta;

}

public static function LeerJSON($archivo)
{
    $file=fopen($archivo,"a+");

    $arrayString = fgets($file);

    $arrayJSON = json_decode($arrayString);


    fclose($file);

    return$arrayJSON;

}

public static function GuardarJSON_Serializado($archivo,$objeto)
{
   
   
    $arrayJSON = Datos::LeerJSON_Serializado($archivo,$objeto);
    $auxArray=array();
    
    if ($arrayJSON==false) {
        array_push($auxArray,$objeto);
       $rta =Datos::Guardar($archivo,serialize($auxArray),"w");
    }
    else {
        array_push($arrayJSON,$objeto);

        $rta =Datos::Guardar($archivo,serialize($arrayJSON),"w");
    }

    return $rta;

}

public static function LeerJSON_Serializado($archivo)
{
    $file=fopen($archivo,"a+");

    $arrayString = fgets($file);
    
    $arrayJSON = unserialize($arrayString);
 
    fclose($file);

    return$arrayJSON;

}



public static function GuardarFoto($name,$tmp_name,$id)
{
   $folder ="imagenes/";
   $folderMarcaAgua ="MarcaAgua/SeekPng.com_itachi-png_1110228.png";
   $name_Array= explode('.', $name);
   $indice= Datos::ultimondice($name_Array);

   $nombre = $id . '-' . time() . '.' . $name_Array[$indice];

   
   move_uploaded_file($tmp_name,$folder.$nombre);
   
   Datos::ImageMerge($folder.$nombre,$folderMarcaAgua,$folder.$nombre,0,0,60);

    return $folder.$nombre;
}

public static function ultimondice($array)
{
    return array_key_last($array);
}


public static function ImageMerge($ImgBase, $ImgMarca, $pathExitImg, $margenX, $margenY, $opacidad)
    {
        $imagenBase  = imagecreatefromjpeg($ImgBase);
        $imagenMarca = imagecreatefrompng($ImgMarca);

        $Iax = imagesx($imagenBase);
        $Iay = imagesy($imagenBase);

        $imagenMarca=imagescale($imagenMarca, $Iax/4, $Iay/4); 

        $ax = imagesx($imagenMarca);
        $ay = imagesy($imagenMarca);

        if(file_exists($ImgBase) && file_exists($ImgMarca))
        {
            if($opacidad < 0 || $opacidad > 100)
            {
                $opacidad = 0;
            }
            imagecopymerge($imagenBase,$imagenMarca,imagesx($imagenBase)-$ax-$margenX,imagesy($imagenBase)-$ay-$margenY,0,0,$ax,$ay,$opacidad);
            imagepng($imagenBase,$pathExitImg);
            imagedestroy($imagenBase);
            return true;
        }
        else
        {
            return false;
        }
    }


}

?>