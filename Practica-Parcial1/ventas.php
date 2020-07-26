<?php

class Venta
{
    public $tipo_producto; 
    public $usuario;
    public $marca;
    public $coste;
    public $id_producto;
    public $cantidad_comprada;


    public function __construct($marca,$coste,$usuario,$id_producto,$tipo_producto,$cantidad_comprada)
    {
        $this->usuario = $usuario;
        $this->marca = $marca;
        $this->coste = $coste;
        $this->id_producto= $id_producto;
        $this->tipo_producto= $tipo_producto;
        $this->cantidad_comprada= $cantidad_comprada;
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

            if ($value->usuario == $payload->nombre) {
               array_push($auxLista,$value);
            }
           
        }

        return $retorno=count($auxLista)>0?$auxLista:"No existen ventas para ese usuario";

        

    }

}

?>