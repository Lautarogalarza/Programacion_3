<?php

class Venta
{
    public $tipo; 
    public $email;
    public $sabor;
    public $coste;
    public $cantidad_comprada;


    public function __construct($tipo,$email,$sabor,$coste,$cantidad_comprada,$fecha)
    {
        $this->tipo = $tipo;
        $this->email = $email;
        $this->sabor = $sabor;
        $this->coste= $coste;
        $this->cantidad_comprada= $cantidad_comprada;
        $this->fecha= $fecha;
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Ventas.json",$this);
       $lista= Datos::GuardarJSON_Serializado("Ventas.json",$this);

        return $lista;

    }

    public static function Ventas_Usuario($payload)
    {
        $auxLista=array();
        $listaJson=Datos::LeerJSON_Serializado("Ventas.json");

        foreach ($listaJson as $value) {

            if ($value->email == $payload->email) {
               array_push($auxLista,$value);
            }
           
        }

        return $retorno=count($auxLista)>0?$auxLista:"No existen ventas para ese usuario";

        

    }

}

?>