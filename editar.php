<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br/>
<?php
        
            $sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
            $sentencia->execute();
            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
        
$producto['ID'] = $_POST['ID'];
$producto['Nombre'] = $_POST['Nombre'];
$producto['Precio'] = $_POST['Precio'];
$producto['Cantidad'] = $_POST['Cantidad'];

$actualizar= "UPDATE 'tblproductos' SET 'Nombre'='$producto[Nombre]', 'Precio'='$producto[Precio]', 'Cantidad'='$producto[Cantidad]' WHERE 'ID'='$producto[ID]";
?>
<?php
include 'templates/pie.php';
?>