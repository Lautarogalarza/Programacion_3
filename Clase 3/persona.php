<?php
require_once './datos.php';

class Persona{

    public $nombre;
    public $apellido;
    public $legajo;

    public function __construct($nombre,$apellido,$legajo)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->legajo = $legajo;
    }

    public function Save()
    {
       $lista= Datos::Guardar("persona.txt",$this->ToFile(),"a");
       $lista= Datos::GuardarJSON("persona.json",$this);

        return $lista;

    }

    public static function Find($id=0)
    {
       // $listaTexto=Datos::LeerTodo("persona.txt");
        $listaJson=Datos::LeerJSON("persona.json");

        if ($id==0) {
            return $listaJson;
        }

       foreach ($listaJson as $value) {
            
           if ($value->legajo == $id) {
                $personaEncontrada = $value;
                break;
           }
             
        }

        return $personaEncontrada;

      
    }

    public function ToFile()
    {
        return $this->nombre ."@".$this->apellido."@".$this->legajo.PHP_EOL;
    }

    public function ToJSON()
    {
        return json_encode($this);
    }


}
?>