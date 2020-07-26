<?php
require_once './datos.php';
require_once './Token.php';

class Usuario{

    public $nombre;
    public $dni;
    public $obra_social;
    public $clave;
    public $tipo;
    public $ID;

    public function __construct($nombre,$dni,$obra_social,$clave,$tipo)
    {
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->obra_social = $obra_social;
        $this->clave = $clave;
        $this->tipo = $tipo;
        $this->ID= Usuario::CalcularId();
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Usuarios.json",$this);
       $lista= Datos::GuardarJSON_Serializado("Usuarios.json",$this);

        return $lista;

    }

    public static function CalcularId()
    {
        //$lista= Datos::LeerJSON("Usuarios.json");
        $lista= Datos::LeerJSON_Serializado("Usuarios.json");
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

    public static function ValidarUserRepetido($user)
    {
        //$listaJson=Datos::LeerJSON("Usuarios.json");
        $listaJson=Datos::LeerJSON_Serializado("Usuarios.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->nombre == $user->nombre) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

public static function validarUser($nombre,$clave){

    //$listaJson=Datos::LeerJSON("Usuarios.json");
    $listaJson=Datos::LeerJSON_Serializado("Usuarios.json");
    $retorno="usuario inexistente";

    foreach ($listaJson as $value) {
            
        if ($value->nombre == $nombre && $value->clave ==$clave) {

            $payload = array(
                "ID" => $value->ID,
                "nombre" => $value->nombre,
                "clave"=> $value->clave,
                "dni" => $value->dni,
                "obra_social" => $value->obra_social,
                "tipo"=> $value->tipo
                        
            );
             $retorno = Token::CrearToken($payload);
             break;
        }
          
     }


     return $retorno;


}



}
?>