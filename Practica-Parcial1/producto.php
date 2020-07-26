<?php
require_once './datos.php';
require_once './ventas.php';

class Producto
{

    public $producto;
    public $marca;
    public $precio;
    public $stock;
    public $foto;
    public $ID;

    public function __construct($producto,$marca,$precio,$stock)
    {
        $this->producto = $producto;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->ID= Producto::CalcularId();
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Productos.json",$this);
        $lista= Datos::GuardarJSON_Serializado("Productos.json",$this);

        return $lista;

    }

    /*public static function ValidarProductoRepetido($producto)
    {
        $listaJson=Datos::LeerJSON("Productos.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->ID == $producto->ID) {
                    $value->stock+=$producto->stock;
                    $value->precio=$producto->precio;
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }*/

    public static function ValidarStock($id,$cantidad,$usuario)
    {
        //$listaJson=Datos::LeerJSON("Productos.json");
        $listaJson=Datos::LeerJSON_Serializado("Productos.json");

        $auxProducto=Producto::Buscar_Guardar_Producto($id,$cantidad,$listaJson);

        if ($auxProducto!=false) {
            
            $venta= new Venta($auxProducto->marca,$auxProducto->precio*$cantidad,$usuario,$auxProducto->ID, $auxProducto->producto,$cantidad);
            $venta->Save();
            $retorno=$venta->coste;
                 
        } else {
            $retorno=false;
        }

        return $retorno;
        
        
    }
    
    public static function Buscar_Guardar_Producto($id,$cantidad,$lista)
    {
        $productoEncontrado=false;
        
        for ($i=0; $i <count($lista); $i++) { 
                    
            if ($lista[$i]->ID==$id && $lista[$i]->stock>=$cantidad) {
              $lista[$i]->stock=$lista[$i]->stock-$cantidad;
              $productoEncontrado=$lista[$i];
            break;
             }
             
        }

       //if (Datos::Guardar("Productos.json",json_encode($lista),"w")==0) {
        if (Datos::Guardar("Productos.json",serialize($lista),"w")==0) {
        $productoEncontrado=false;
       } 
        
        return $productoEncontrado;

      
    }


    public static function CalcularId()
    {
        //$lista= Datos::LeerJSON("Productos.json");
        $lista= Datos::LeerJSON_Serializado("Productos.json");
        $id;

        if($lista==false)
        {
            $id=1;
        }
        else {
            $id=count($lista)+1;
        }

        return $id;

    }

}

?>