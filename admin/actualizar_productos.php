<?php
include 'global/config.php';
include 'global/conexion.php';

header('Content-Type: application/json');

try {
    // Get JSON input
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (!isset($data['productos']) || empty($data['productos'])) {
        throw new Exception('No se recibieron datos para actualizar');
    }

    $pdo->beginTransaction();

    foreach ($data['productos'] as $producto) {
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

        if (!$resultado) {
            throw new Exception('Error al actualizar el producto ID: ' . $producto['ID']);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Productos actualizados correctamente'
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 