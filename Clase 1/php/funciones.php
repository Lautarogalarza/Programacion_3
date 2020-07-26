<?php

include_once "saludar.php";
include_once "persona.php";

function saludarEsp($edad,$nombre="Lautaro"){

   saludar(21,$nombre);

  }

  function saludarPersona($edad,$nombre="Lautaro"){

   $persona = new Persona($edad,$nombre);//instancio una persona

   $persona->saludar();//llamo al metodo de instancia

   Persona::mostrar($persona);

  }  

?>