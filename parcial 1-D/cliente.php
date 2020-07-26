<?php
require_once './datos.php';
require_once './Token.php';

class Cliente{

    public $email;
    public $clave;
    public $tipo;


    public function __construct($email,$clave,$tipo)
    {
        $this->email = $email;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }

    public function Save()
    {
       //$lista= Datos::GuardarJSON("Usuarios.json",$this);
       $lista= Datos::GuardarJSON_Serializado("Users.json",$this);

        return $lista;

    }

    public static function CalcularId()
    {
        //$lista= Datos::LeerJSON("Usuarios.json");
        $lista= Datos::LeerJSON_Serializado("Users.json");
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
        $listaJson=Datos::LeerJSON_Serializado("Users.json");
        $retorno=false;

        if ($listaJson!=false) {
            foreach ($listaJson as $value) {
            
                if ($value->email == $user->email) {
                     $retorno = true;
                     break;
                }
                  
             }
        }
    
         return $retorno;

    }

public static function validarUser($email,$clave){

    //$listaJson=Datos::LeerJSON("Usuarios.json");
    $listaJson=Datos::LeerJSON_Serializado("Users.json");
    $retorno="usuario inexistente";

    foreach ($listaJson as $value) {
            
        if ($value->email == $email && $value->clave ==$clave) {

            $payload = array(
                "email" => $value->email,
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