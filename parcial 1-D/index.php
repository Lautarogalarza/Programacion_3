<?php
require_once './cliente.php';
require_once './pizza.php';
require_once './response.php';
require_once './Token.php';
require_once './ventas.php';


$method= $_SERVER["REQUEST_METHOD"];
$path=  $_SERVER["PATH_INFO"]??"ruta inexistente";

$response= new Response();
switch ($path) {

    
    case '/usuario':

        if ($method=="POST") {

            if ($method=="POST") {
            
                $email=$_POST['email'] ?? null; 
                $clave =$_POST['clave'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
    
                if (isset($email)&&isset($clave)&&isset($tipo)) {
    
                    if ($tipo=="encargado"|| $tipo=="cliente") {
                        $user = new Cliente($email,$clave,$tipo);

                    if(Cliente::ValidarUserRepetido($user))
                    {
                        $response->data = "Usuario repetido";
                        $response->status = "failed";
                    }
                    else {

                         $rta=$user->Save();
                         $response->data = $rta;
                    }

                    }
                    else {
                        $response->data = "tipo de usuario incorrecto";
                        $response->status = "failed";
                    }
            
        
                }
                else{
                    $response->data = "faltan datos";
                    $response->status = "failed";
    
                }
    
            }

   

        } else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
       
        break;
    case '/login':
        
        if ($method=="POST") {

            $email=$_POST['email'] ?? null; 
            $clave= $_POST['clave'] ?? null; 

            if (isset($email)&&isset($clave)) {

                    $rta=Cliente::validarUser($email,$clave);
                    $response->data = $rta;
              
    
            }
            else{
                $response->data = "faltan datos";
                $response->status = "failed";

            }



        
        } else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
         break;
         
     case '/pizzas':

        if ($method=="POST") {

            $headers=getallheaders();

            $tipo=$_POST['tipo'] ?? null; 
            $precio= $_POST['precio'] ?? null; 
            $stock =$_POST['stock'] ?? null;
            $sabor =$_POST['sabor'] ?? null;
            $name=$_FILES["foto"]["name"]??null;
            $tmp_name=$_FILES["foto"]["tmp_name"]??null;
            $Token=$headers["token"]??"";

           $payload = Token::ValidarToken($Token);

           if ($payload!=null) {
               
               if (Token::EsEncargado($payload)) {
                   
                   if (isset($tipo)&&isset($precio)&&isset($stock)&&isset($sabor)&& isset($name)) { 
                       
                       if ($tipo=="molde" || $tipo=="piedra" && $sabor=="napo"|| $sabor=="muzza"|| $sabor=="jamon") {
       
       
                           $nuevoProducto = new Pizza($tipo,$stock,$precio,$sabor);

                           if (Pizza::ValidarTipoSabor($nuevoProducto)) {
                               $nuevoProducto->foto=Datos::GuardarFoto($name,$tmp_name,$nuevoProducto->tipo."-".$nuevoProducto->sabor);
                               $rta=$nuevoProducto->Save();
                               $response->data = $rta;
                           }
                           else {

                            $response->data = "combinacion de producto/sabor repetida";
                            $response->status = "failed";
                               
                           }

       
                       } 
                       else {
       
                           $response->data = "tipo de producto/sabor incorrecto";
                           $response->status = "failed";
                           
                       }
       
                       }
       
                       else {
                           $response->data = "faltan datos";
                           $response->status = "failed";
                       }
               }
               else
               {
                   $response->data = "Tipo de usuario no permitido";
                    $response->status = "failed";
               }
           }
           else
           {
            $response->data = "Token invalido";
            $response->status = "failed";
           }


 
        } 
        elseif ($method=="GET") {

            $headers=getallheaders();
            $Token=$headers["token"]??"";

            $payload = Token::ValidarToken($Token);

            if ($payload!=null) {

                if (Token::EsEncargado($payload)) {
                    
                    //$lista= Datos::LeerJSON("Productos.json");
                    $lista= Datos::LeerJSON_Serializado("Pizzas.json");
                    if ($lista!=false) {
        
                        $response->data =$lista;
                    } else {
                        $response->data = "Lista vacia";
                        $response->status = "failed";
                    }
                }
                else {

                    $lista= Datos::LeerJSON_Serializado("Pizzas.json");
                    
                    if ($lista!=false) {

                        $objecto = new stdClass();
                        $listaFiltrada = array();

                        foreach ($lista as $value) {

                                $objecto->tipo = $value->tipo;
                                $objecto->precio = $value->precio;
                                $objecto->sabor= $value->sabor;
                                $objecto->foto= $value->foto;
                                array_push( $listaFiltrada,$objecto);
                                $objecto= new stdClass();                     
                           
                        }

                    
                        $response->data =$listaFiltrada;
                    } else {
                        $response->data = "Lista vacia";
                        $response->status = "failed";
                    }
                   
                }
            }
            else {
                $response->data = "Token invalido";
                $response->status = "failed";
            }
               

            
           
        } 
        
        
        else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
    break;

    case '/ventas':

        if ($method=="POST") {

            $headers=getallheaders();

            $tipo= $_POST['tipo'] ?? null; 
            $sabor =$_POST['sabor'] ?? null;
            $Token=$headers["token"]??"";

           $payload = Token::ValidarToken($Token);

           if ( $payload!=null) {
            
               if (Token::EsEncargado($payload)==false) {
    
                   if (isset($tipo)&&isset($sabor)) {
    
                      $auxStock= Pizza::ValidarStock($tipo,$sabor,$payload->email);
                       
                       if ($auxStock!=false) {
                           $response->data = $auxStock;
                       } else {
                           $response->data = "Id inexisitente o falta de stock";
                           $response->status = "failed";
                       }
                            
                       
                   } else {
                       $response->data = "faltan datos";
                       $response->status = "failed";
                   }
                   
                   }
                   else
                   {
                       $response->data = "Tipo de usuario no permitido";
                       $response->status = "failed";
                   }
           }
           else {
            $response->data = "Token invalido";
            $response->status = "failed";
           }




        }
        elseif ($method=="GET") {

            $headers=getallheaders();
            $Token=$headers["token"]??"";

            $payload = Token::ValidarToken($Token);
            $lista;

            if ($payload!=null) {
                
                if (Token::EsEncargado($payload)                        ) {
    
                    $lista=Datos::LeerJSON_Serializado("Ventas.json");
                    $respuesta=count($lista)>0?$lista:"No existen ventas";
                    $response->data =$respuesta;
                }
                else{
                    
                       $lista=Venta::Ventas_Usuario($payload);
                       $response->data = $lista;                    

                }
            }
            else
            {
                $response->data = "Autentificacion invalida";
                $response->status = "failed";
            }

       
        }  
        
        else {
            $response->data = "Metodo no permitido";
            $response->status = "failed";
        }
        
        
         break;

          case '/fotos':

            if ($method=="POST") {

                $name=$_FILES["foto"]["name"]??null;
                $tmp_name=$_FILES["foto"]["tmp_name"]??null;
    
                Datos::GuardarFoto($name,$tmp_name,111);
            }

             break;
         
    default:
    $response->data = "Ruta inexistente";
    $response->status = "failed";
        break;
    }
    
    echo json_encode($response);
    
    
?>