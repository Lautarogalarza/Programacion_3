<?php
var_dump($_FILES["archivo"]);


if ($_FILES["archivo"]["size"]>10000) {
   // echo "error de tamaño";
    
}


$name=$_FILES["archivo"]["name"];
$tmp_name=$_FILES["archivo"]["tmp_name"];
$folder ="images/";
$name_Array= explode('.', $name);
$indice= indice::ultimondice($name_Array);

$nombre = $_POST['legajo'] . '-' . time() . '.' . $name_Array[$indice];


echo move_uploaded_file($tmp_name,$folder.$nombre);



/*$origen="images/444-1588394442.jpg";
$destino="images_backup/444-1588394442.jpg";

if(copy($origen,$destino))
{
    
    unlink("images/444-1588394442.jpg");
}*/


class indice{

    public static function ultimondice($array)
    {
        return array_key_last($array);
    }
}


?>
