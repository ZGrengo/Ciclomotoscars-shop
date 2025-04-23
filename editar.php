<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br/>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ID']) && isset($_POST['Nombre']) && isset($_POST['Precio']) && isset($_POST['Cantidad'])) {
        $producto = [
            'ID' => $_POST['ID'],
            'Nombre' => $_POST['Nombre'],
            'Precio' => $_POST['Precio'],
            'Cantidad' => $_POST['Cantidad']
        ];

        $sentencia = $pdo->prepare("UPDATE tblproductos 
                                  SET Nombre = :nombre, 
                                      Precio = :precio, 
                                      Cantidad = :cantidad 
                                  WHERE ID = :id");

        $resultado = $sentencia->execute([
            ':nombre' => $producto['Nombre'],
            ':precio' => $producto['Precio'],
            ':cantidad' => $producto['Cantidad'],
            ':id' => $producto['ID']
        ]);

        if ($resultado) {
            echo '<div class="alert alert-success">Producto actualizado correctamente</div>';
        } else {
            echo '<div class="alert alert-danger">Error al actualizar el producto</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Faltan datos requeridos</div>';
    }
}
?>
<a href="administrar.php" class="btn btn-primary">Volver a Administración</a>
<?php
include 'templates/pie.php';
?>