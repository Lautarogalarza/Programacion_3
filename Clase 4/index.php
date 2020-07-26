<?php
include_once 'persona.php';

$personas = array();

array_push($personas,new Persona("lautaro"));
array_push($personas,new Persona("marcelo"));
array_push($personas,new Persona("damian"));
array_push($personas,new Persona("ezequiel"));

/*$file =fopen("personas.txt","w");

$rta = fwrite($file,serialize($personas));

fclose($file);*/

$file =fopen("personas.txt","r");
$rta = fread($file,filesize("personas.txt"));

//echo $rta;

$personasDeserializadas= unserialize($rta);

//print_r($personasDeserializadas);//var_dump bonito

foreach ($personasDeserializadas as $persona) {
    echo $persona->saludar() . "<br>";
}

?>