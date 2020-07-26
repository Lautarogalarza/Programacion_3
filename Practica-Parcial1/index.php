<?php
require_once './usuario.php';
require_once './producto.php';
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
            
                $nombre=$_POST['nombre'] ?? null; 
                $dni= $_POST['dni'] ?? null; 
                $obra_social =$_POST['obra_social'] ?? null;
                $clave =$_POST['clave'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
    
                if (isset($nombre)&&isset($dni)&&isset($obra_social)&&isset($clave)&&isset($tipo)) {
    
                    if ($tipo=="user"|| $tipo=="admin") {
                        $user = new Usuario($nombre,$dni,$obra_social,$clave,$tipo);

                    if(Usuario::ValidarUserRepetido($user))
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

            $nombre=$_POST['nombre'] ?? null; 
            $clave= $_POST['clave'] ?? null; 

            if (isset($nombre)&&isset($clave)) {

                    $rta=Usuario::validarUser($nombre,$clave);
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
         
     case '/stock':

        if ($method=="POST") {

            $headers=getallheaders();

            $producto=$_POST['producto'] ?? null; 
            $marca= $_POST['marca'] ?? null; 
            $precio =$_POST['precio'] ?? null;
            $stock =$_POST['stock'] ?? null;
            $name=$_FILES["foto"]["name"]??null;
            $tmp_name=$_FILES["foto"]["tmp_name"]??null;
            $Token=$headers["token"]??"";

           $payload = Token::ValidarToken($Token);

           if ($payload!=null) {
               
               if (Token::EsAdmin($payload)) {
                   
                   if (isset($producto)&&isset($marca)&&isset($precio)&&isset($stock)&& isset($name)) { 
                       
                       if ($producto=="vacuna" || $producto=="medicamento") {
       
       
                           $nuevoProducto = new Producto($producto,$marca,$precio,$stock);
                          // Producto::ValidarProductoRepetido($nuevoProducto);
                           $nuevoProducto->foto=Datos::GuardarFoto($name,$tmp_name,$nuevoProducto->ID);
                           $rta=$nuevoProducto->Save();
                           $response->data = $rta;
       
                           
       
                       } 
                       else {
       
                           $response->data = "tipo de producto incorrecto";
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

            //$lista= Datos::LeerJSON("Productos.json");
            $lista= Datos::LeerJSON_Serializado("Productos.json");
            if ($lista!=false) {

                $response->data =$lista;
            } else {
                $response->data = "Lista vacia";
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

            $id_producto=$_POST['id_producto'] ?? null; 
            $cantidad= $_POST['cantidad'] ?? null; 
            $ususario =$_POST['usuario'] ?? null;
            $Token=$headers["token"]??"";

           $payload = Token::ValidarToken($Token);

           if ( $payload!=null) {
            
               if (Token::EsAdmin($payload)==false) {
    
                   if (isset($id_producto)&&isset($cantidad)&&isset($ususario)) {
    
                      $auxStock= Producto::ValidarStock($id_producto,$cantidad,$ususario);
                       
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
                
                if (Token::EsAdmin($payload)                        ) {
    
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