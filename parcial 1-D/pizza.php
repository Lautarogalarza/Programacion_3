<?php
require_once './datos.php';
require_once './ventas.php';

class Pizza
{

    public $tipo;
    public $precio;
    public $stock;
    public $sabor;
    public $foto;

    public function __construct($tipo,$stock,$precio,$sabor)
    {
        $this->tipo = $tipo;
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Productos.json",$this);
        $lista= Datos::GuardarJSON_Serializado("Pizzas.json",$this);

        return $lista;

    }

    public static function ValidarTipoSabor($producto)
    {
        $listaJson=Datos::LeerJSON_Serializado("Pizzas.json");
        $retorno=true;

        
        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->tipo == $producto->tipo && $value->sabor == $producto->sabor) {
                     $retorno = false;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

    public static function ValidarStock($tipo,$sabor,$email)
    {
        //$listaJson=Datos::LeerJSON("Productos.json");
        $listaJson=Datos::LeerJSON_Serializado("Pizzas.json");


        $auxProducto=Pizza::Buscar_Guardar_Producto($email,1,$listaJson,$tipo,$sabor);
        $segundos=time();
        $fecha=date('d_m_Y',$segundos);

        if ($auxProducto!=false) {
            
            $venta= new Venta($tipo,$email,$sabor,$auxProducto->precio,1,$fecha);
            $venta->Save();
            $retorno=$venta->coste;
                 
        } else {
            $retorno=false;
        }

        return $retorno;
        
        
    }
    
    public static function Buscar_Guardar_Producto($email,$cantidad,$lista,$tipo,$sabor)
    {
        $productoEncontrado=false;

        
        for ($i=0; $i <count($lista); $i++) {

                    
            if ( $lista[$i]->stock>=$cantidad && $lista[$i]->sabor==$sabor && $lista[$i]->tipo==$tipo) {

              $lista[$i]->stock=$lista[$i]->stock-$cantidad;
              $productoEncontrado=$lista[$i];

            break;
             }
             
        }


       //if (Datos::Guardar("Productos.json",json_encode($lista),"w")==0) {
        if (Datos::Guardar("Pizzas.json",serialize($lista),"w")==0) {
        $productoEncontrado=false;
       } 
        
        return $productoEncontrado;

      
    }


  

}

?>