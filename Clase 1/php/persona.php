<?php

class Persona{

public $nombre;
public $edad;


public function __construct($edad,$nombre)//constructor
{
    $this->nombre = $nombre;
    $this->edad = $edad;
}

public function saludar()
{
    print("Hola $this->nombre  Tenes  $this->edad  años <br> <br>");//concatenar
}

public static function mostrar($persona)
{
    print("Hola $persona->nombre  Tenes  $persona->edad  años estaticos");
}


}

?>