<?php
session_start();

$mensaje="";

if(isset($_POST['btnAction'])){
        
    
    switch($_POST['btnAction']){

        case 'Agregar':
           //encriptacion de datos 
            if(is_numeric(openssl_decrypt($_POST['id'],COD,KEY))){
                $ID=openssl_decrypt($_POST['id'],COD,KEY);
                $mensaje.="Ok ID correcto".$ID."<br/>";

            }else{
                    $mensaje.="Id incorrecto".$ID."<br/>";  
            }


        if(is_string(openssl_decrypt($_POST['nombre'],COD,KEY))){
            $NOMBRE=openssl_decrypt($_POST['nombre'],COD,KEY);
            $mensaje.="Nombre ok".$NOMBRE."<br/>";
        }else{
                $mensaje.="Nombre incorrecto".$ID."<br/>"; 
            break; 
        }


            if(is_numeric(openssl_decrypt($_POST['cantidad'],COD,KEY))){
            $CANTIDAD=openssl_decrypt($_POST['cantidad'],COD,KEY);
            $mensaje.="Cantidad ok".$CANTIDAD."<br/>";
        }else{
                $mensaje.="Cantidad incorrecto".$ID."<br/>"; 
            break; 
        }


                if(is_numeric(openssl_decrypt($_POST['precio'],COD,KEY))){
            $PRECIO=openssl_decrypt($_POST['precio'],COD,KEY);
            $mensaje.="Precio ok".$PRECIO."<br/>";
        }else{
                $mensaje.="precio incorrecto".$ID."<br/>"; 
            break; 
        }
        //Productos seleccionados por el usuario
        if(!isset($_SESSION['CARRITO'])){
            $producto=array(
                'ID'=>$ID,
                'NOMBRE'=>$NOMBRE,
                'CANTIDAD'=>$CANTIDAD,
                'PRECIO'=>$PRECIO
            );
            $_SESSION['CARRITO'][0]=$producto;
            $mensaje= "Producto agregado al carrito";
        }else{
            //Verificacion de producto previamente seleccionado
            $idProductos=array_column($_SESSION['CARRITO'],"ID");
            if(in_array($ID,$idProductos)){
                echo "<script>alert('El producto ya ha sido seleccionado');</script>";
                $mensaje="";

            }else{

            $NumeroProductos=count($_SESSION['CARRITO']);
            $producto=array(
                'ID'=>$ID,
                'NOMBRE'=>$NOMBRE,
                'CANTIDAD'=>$CANTIDAD,
                'PRECIO'=>$PRECIO
            ); 


            $_SESSION['CARRITO'][$NumeroProductos]=$producto;
            $mensaje= "Producto agregado al carrito";
        }
        }
        //$mensaje= print_r( $_SESSION,true);
        

    break;
    //boton de eliminar producto
    case "Eliminar":

        if(is_numeric(openssl_decrypt($_POST['id'],COD,KEY))){
            $ID=openssl_decrypt($_POST['id'],COD,KEY);
            

            foreach($_SESSION['CARRITO'] as $indice=>$producto){
                if($producto['ID']==$ID){
                    unset($_SESSION['CARRITO'][$indice]);
                    echo "<script>alert('Elemento borrado');</script>";

                }


            }

        }else{
                $mensaje.="Id incorrecto".$ID."<br/>";  
        }

    break;
    
    case "Actualizar":
        

}

}

?>

