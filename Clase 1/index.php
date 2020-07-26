<?php


/*$nombre = "Lautaro";
//$nombre = 12;

print("Hola PHP $nombre");
echo "Hola PHP", $nombre;
printf("Hola PHP %s",$nombre);
print(strtoupper($nombre));*/

$array =array(1,2.6,3,4,5,"lauti","clave"=>8);//declarar array

array_push($array,12);

/*$array[0]=1;
$array[1]=2;
$array[2]=3;
$array[3]=4;
$array[4]=5;
$array[5]="lauti";
$array["seis"]=7;//otra forma de cargar el array*/


//var_dump($array);//muestra toda la informacion de mi array

foreach ($array as $key => $value) {//recorro el array por sus indices
   print("$key <br>");
}

foreach ($array as  $value) {//recorro el array por sus valores
    print("$value <br>");
 }

?>