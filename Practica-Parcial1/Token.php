<?php
include "composer/vendor/autoload.php";
use \Firebase\JWT\JWT;

class Token
{

    public static $key = "Mi_Secreto";

    public static function CrearToken($payload)
    {
        
        return JWT::encode($payload, Token::$key);
    }


    public static function ValidarToken($Token)
    {
        
        try {
            return JWT::decode($Token,Token::$key, array('HS256'));//devuelve el payload

        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function EsAdmin($payload)
    {

        try {
            if ($payload->tipo=="admin") {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
    }



}


?>