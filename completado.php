<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include 'global/config.php';
include 'global/conexion.php';
include 'templates/cabecera.php';

// Get the order ID from the URL
$orderID = isset($_GET['orderID']) ? $_GET['orderID'] : '';

// Query the database for the order details
$sentencia = $pdo->prepare("SELECT * FROM tblventas WHERE ClaveTransaccion = :orderID");
$sentencia->bindParam(":orderID", $orderID);
$sentencia->execute();
$venta = $sentencia->fetch(PDO::FETCH_ASSOC);

// If we have a valid sale, send the confirmation email
if ($venta) {
    // Get the purchased items
    $sentencia = $pdo->prepare("
        SELECT d.*, p.Nombre, p.Precio 
        FROM tbldetalleventa d 
        JOIN tblproductos p ON d.IDProducto = p.ID 
        WHERE d.IDVenta = :idVenta
    ");
    $sentencia->bindParam(":idVenta", $venta['ID']);
    $sentencia->execute();
    $productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    require 'vendor/autoload.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress($venta['Correo']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Compra - ' . SMTP_FROM_NAME;
        
        // Build the products list HTML
        $productosHTML = '';
        $productosText = '';
        foreach ($productos as $producto) {
            $productosHTML .= '<li>' . htmlspecialchars($producto['Nombre']) . 
                            ' - Cantidad: ' . $producto['CANTIDAD'] . 
                            ' - Precio: $' . number_format($producto['Precio'], 2) . 
                            ' - Subtotal: $' . number_format($producto['CANTIDAD'] * $producto['Precio'], 2) . '</li>';
            
            $productosText .= $producto['Nombre'] . ' - Cantidad: ' . $producto['CANTIDAD'] . 
                            ' - Precio: $' . number_format($producto['Precio'], 2) . 
                            ' - Subtotal: $' . number_format($producto['CANTIDAD'] * $producto['Precio'], 2) . "\n";
        }
        
        // Email body
        $mail->Body = '
            <h2>¡Gracias por tu compra!</h2>
            <p>Tu pedido ha sido procesado correctamente.</p>
            <h3>Detalles de la compra:</h3>
            <ul>
                <li><strong>ID de Transacción:</strong> ' . htmlspecialchars($venta['ClaveTransaccion']) . '</li>
                <li><strong>Total:</strong> $' . number_format($venta['Total'], 2) . '</li>
                <li><strong>Fecha:</strong> ' . date('d/m/Y H:i', strtotime($venta['Fecha'])) . '</li>
            </ul>
            <h3>Productos comprados:</h3>
            <ul>
                ' . $productosHTML . '
            </ul>
            <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
            <p>Saludos,<br>' . SMTP_FROM_NAME . '</p>
        ';

        $mail->AltBody = 'Gracias por tu compra. ID de Transacción: ' . $venta['ClaveTransaccion'] . 
                        '. Total: $' . number_format($venta['Total'], 2) . 
                        '. Fecha: ' . date('d/m/Y H:i', strtotime($venta['Fecha'])) . "\n\n" .
                        'Productos comprados:\n' . $productosText;

        $mail->send();
        $emailSent = true;
    } catch (Exception $e) {
        $emailSent = false;
        error_log("Error al enviar el correo: " . $mail->ErrorInfo);
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 200px);">
    <div class="jumbotron text-center w-100" style="max-width: 600px;">
        <h1 class="display-4">¡Pago Completado!</h1>
        <hr class="my-4">
        <?php if ($venta): ?>
            <div class="alert alert-success">
                <h4 class="alert-heading">¡Gracias por tu compra!</h4>
                <p>Tu pago ha sido procesado correctamente.</p>
                <hr>
                <p class="mb-0">
                    <strong>ID de Transacción:</strong> <?php echo htmlspecialchars($venta['ClaveTransaccion']); ?><br>
                    <strong>Total:</strong> $<?php echo number_format($venta['Total'], 2); ?><br>
                    <strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($venta['Fecha'])); ?>
                </p>
            </div>
            <p class="lead">
                <?php if (isset($emailSent) && $emailSent): ?>
                    Te hemos enviado un correo electrónico a <?php echo htmlspecialchars($venta['Correo']); ?> con los detalles de tu compra.
                <?php else: ?>
                    Te enviaremos un correo electrónico a <?php echo htmlspecialchars($venta['Correo']); ?> con los detalles de tu compra.
                <?php endif; ?>
            </p>
            <a href="index.php" class="btn btn-warning btn-lg">Volver a la tienda</a>
        <?php else: ?>
            <div class="alert alert-warning">
                <h4 class="alert-heading">¡Ups!</h4>
                <p>No se encontró información sobre esta transacción.</p>
                <hr>
                <p class="mb-0">Si crees que esto es un error, por favor contacta a soporte.</p>
            </div>
            <a href="index.php" class="btn btn-warning btn-lg">Volver a la tienda</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'templates/pie.php'; ?> 