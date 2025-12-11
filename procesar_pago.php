<?php
// Disable error display and enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Set headers first to ensure only JSON is output
header('Content-Type: application/json');

// Start session after headers
session_start();

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'orderID' => null
];

try {
    // Include files
    if (!@include 'global/config.php') {
        throw new Exception('Failed to include config.php');
    }
    if (!@include 'global/conexion.php') {
        throw new Exception('Failed to include conexion.php');
    }

    // Get POST data
    $rawData = file_get_contents('php://input');
    if ($rawData === false) {
        throw new Exception('Failed to read POST data');
    }

    $data = json_decode($rawData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }

    if ($data) {
        // Verify required data is present
        if (!isset($data['orderID']) || !isset($data['total']) || !isset($data['email'])) {
            throw new Exception('Missing required payment data');
        }

        // Start transaction
        $pdo->beginTransaction();

        try {
            // Insert into tblventas
            $sentencia = $pdo->prepare("INSERT INTO `tblventas` 
                (`ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
                VALUES (:ClaveTransaccion, :PaypalDatos, NOW(), :Correo, :Total, 'completado')");

            if (!$sentencia) {
                throw new Exception('Failed to prepare SQL statement for tblventas');
            }

            // Bind parameters
            $sentencia->bindParam(":ClaveTransaccion", $data['orderID']);
            $sentencia->bindParam(":PaypalDatos", json_encode($data['details']));
            $sentencia->bindParam(":Correo", $data['email']);
            $sentencia->bindParam(":Total", $data['total']);

            // Execute the query
            $result = $sentencia->execute();
            
            if (!$result) {
                $errorInfo = $sentencia->errorInfo();
                throw new Exception("Database error in tblventas: " . $errorInfo[2]);
            }

            $idVenta = $pdo->lastInsertId();

            // Insert into tbldetalleventa for each item in the cart
            if (isset($_SESSION['CARRITO']) && !empty($_SESSION['CARRITO'])) {
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    $sentencia = $pdo->prepare("INSERT INTO `tbldetalleventa` 
                        (`IDVenta`, `IDProducto`, `PrecioUnitario`, `Cantidad`) 
                        VALUES (:IDVenta, :IDProducto, :PrecioUnitario, :Cantidad)");

                    if (!$sentencia) {
                        throw new Exception('Failed to prepare SQL statement for tbldetalleventa');
                    }

                    $sentencia->bindParam(":IDVenta", $idVenta);
                    $sentencia->bindParam(":IDProducto", $producto['ID']);
                    $sentencia->bindParam(":PrecioUnitario", $producto['PRECIO']);
                    $sentencia->bindParam(":Cantidad", $producto['CANTIDAD']);

                    $result = $sentencia->execute();
                    if (!$result) {
                        $errorInfo = $sentencia->errorInfo();
                        throw new Exception("Database error in tbldetalleventa: " . $errorInfo[2]);
                    }
                }
            }

            // Commit transaction
            $pdo->commit();

            // Clear the cart
            if (isset($_SESSION['CARRITO'])) {
                unset($_SESSION['CARRITO']);
            }

            // Set success response
            $response = [
                'success' => true,
                'orderID' => $data['orderID'],
                'message' => 'Pago procesado correctamente'
            ];
        } catch (Exception $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            throw $e;
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'No se recibieron datos del pago'
        ];
    }
} catch (Exception $e) {
    error_log("Error in procesar_pago.php: " . $e->getMessage());
    $response = [
        'success' => false,
        'message' => 'Error al procesar el pago: ' . $e->getMessage()
    ];
}

// Output JSON response
echo json_encode($response);
exit;
?> 