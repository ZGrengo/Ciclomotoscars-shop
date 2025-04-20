<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ajusta la ruta según tu estructura
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensajeUsuario = htmlspecialchars($_POST['mensaje']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress(SMTP_FROM, 'Destino');

        $mail->isHTML(true);
        $mail->Subject = "Nuevo mensaje de contacto";
        $mail->Body = "
            <strong>Nombre:</strong> {$nombre}<br>
            <strong>Email:</strong> {$email}<br>
            <strong>Mensaje:</strong><br>{$mensajeUsuario}
        ";

        $mail->send();
        $mensaje = "<div class='alert alert-success'>Mensaje enviado correctamente.</div>";
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error al enviar: {$mail->ErrorInfo}</div>";
    }
}
?>

<main class="d-flex align-items-center justify-content-center" style="background-color: #000; min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card bg-dark border-warning shadow-lg">
                    <div class="card-body p-4">
                        <h2 class="text-warning text-center mb-3">Contáctanos</h2>
                        
                        <?php if (!empty($mensaje)) echo $mensaje; ?>

                        <form action="enviar_email.php" method="POST">
                            <div class="form-group">
                                <label for="nombre" class="text-white">Nombre</label>
                                <input type="text" class="form-control bg-white text-dark border-warning" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="email" class="text-white">Email</label>
                                <input type="email" class="form-control bg-white text-dark border-warning" id="email" name="email" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="asunto" class="text-white">Asunto</label>
                                <input type="text" class="form-control bg-white text-dark border-warning" id="asunto" name="asunto" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="mensaje" class="text-white">Mensaje</label>
                                <textarea class="form-control bg-white text-dark border-warning" id="mensaje" name="mensaje" rows="5" required></textarea>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-warning btn-block">Enviar Mensaje</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .form-control:focus {
        background-color: #fff;
        color: #000;
        border-color: #FFC800;
        box-shadow: 0 0 0 0.2rem rgba(255, 200, 0, 0.25);
    }
    
    .btn-warning {
        background-color: #FFC800;
        border-color: #FFC800;
        color: #000;
        font-weight: bold;
    }
    
    .btn-warning:hover {
        background-color: #e6b400;
        border-color: #e6b400;
        color: #000;
    }

    .card {
        border-radius: 1rem;
    }
    
    html, body {
        background-color: #000 !important;
        height: 100%;
        margin: 0;
    }

    main {
        background-color: #000;
    }
</style>

<?php include 'templates/pie.php'; ?>