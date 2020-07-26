<?php
include "composer/vendor/autoload.php";
use \Firebase\JWT\JWT;

$key = "example_key";
$payload = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000,
    "nombre"=> "lautaro",
    "correo"=> "lautaro@gmail.com",
    "user_type"=>"admin",
    "imag"=> "foto"
);

//$jwt = JWT::encode($payload, $key);

$headers=getallheaders();

$Token=$headers["token"]??"";

try {
    $decoded = JWT::decode($Token, $key, array('HS256'));//devuelve el payload
    print_r($decoded);
} catch (\Throwable $th) {
   echo $th->getMessage();
}






?>