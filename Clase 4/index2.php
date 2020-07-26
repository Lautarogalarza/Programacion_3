<?php

session_start();

setcookie("noombre","lauti",time()+10);//al final le digo cuanto expira


//print_r($_SESSION);

$nombre =  $_SESSION["nombre"] ?? false;

if ($nombre==false) {
    $_SESSION["nombre"] = $_GET["nombre"]??"vacio";
    echo "sesion guardada";
}
else {
    echo "hola ". $_SESSION["nombre"];
}

//session_destroy();*/


?>