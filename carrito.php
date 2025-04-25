<?php
require_once __DIR__ . '/global/init.php';

$mensaje = "";

if(!isset($_SESSION['CARRITO'])){
    $_SESSION['CARRITO'] = array();
}

if(isset($_POST['btnAction'])){
    // Decrypt the ID first
    $id = openssl_decrypt($_POST['id'], COD, KEY);
    if(!$id) {
        $mensaje = "Error: ID inválido";
    } else {
        switch($_POST['btnAction']){
            case 'Agregar':
                if(!isset($_SESSION['CARRITO'][$id])){
                    $producto = array(
                        'ID' => $id,
                        'NOMBRE' => openssl_decrypt($_POST['nombre'], COD, KEY),
                        'PRECIO' => openssl_decrypt($_POST['precio'], COD, KEY),
                        'CANTIDAD' => openssl_decrypt($_POST['cantidad'], COD, KEY),
                        'IMAGEN' => openssl_decrypt($_POST['imagen'], COD, KEY)
                    );
                    $_SESSION['CARRITO'][$id] = $producto;
                    $mensaje = "Producto agregado al carrito";
                } else {
                    $_SESSION['CARRITO'][$id]['CANTIDAD'] += openssl_decrypt($_POST['cantidad'], COD, KEY);
                    $mensaje = "Cantidad actualizada";
                }
                break;

            case 'Mas':
                if(isset($_SESSION['CARRITO'][$id])){
                    $_SESSION['CARRITO'][$id]['CANTIDAD'] += 1;
                    $mensaje = "Cantidad aumentada";
                }
                break;

            case 'Menos':
                if(isset($_SESSION['CARRITO'][$id])){
                    $_SESSION['CARRITO'][$id]['CANTIDAD'] -= 1;
                    if($_SESSION['CARRITO'][$id]['CANTIDAD'] <= 0){
                        unset($_SESSION['CARRITO'][$id]);
                        $mensaje = "Producto eliminado del carrito";
                    } else {
                        $mensaje = "Cantidad disminuida";
                    }
                }
                break;

            case 'Eliminar':
                if(isset($_SESSION['CARRITO'][$id])){
                    unset($_SESSION['CARRITO'][$id]);
                    $mensaje = "Producto eliminado del carrito";
                }
                break;
        }
    }
}
?>

