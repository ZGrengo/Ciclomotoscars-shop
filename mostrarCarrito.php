<?php
include 'global/config.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>

<main class="bg-black min-vh-100 py-4">
    <div class="container">
        <h2 class="text-warning text-center mb-5">
            <i class="bi bi-cart3"></i> Carrito de Compras
        </h2>

        <?php if (!empty($_SESSION['CARRITO'])) { ?>
            <div class="table-responsive">
                <table class="table table-dark table-bordered border-warning text-white align-middle">
                    <thead class="bg-warning text-black">
                        <tr>
                            <th>Imagen</th>
                            <th>Descripción</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Total</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                            <tr class="hover-row">
                                <td class="text-center">
                                    <img src="<?php echo $producto['IMAGEN']; ?>" alt="Producto" width="60" height="60" class="rounded">
                                </td>
                                <td><?php echo $producto['NOMBRE']; ?></td>
                                <td class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                                <td class="text-center">$<?php echo $producto['PRECIO']; ?></td>
                                <td class="text-center">$<?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
                                <td class="text-center">
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                        <button class="btn btn-outline-danger btn-sm" type="submit" name="btnAction" value="Eliminar">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php $total += ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-end"><h4>Total:</h4></td>
                            <td class="text-center"><h4>$<?php echo number_format($total, 2); ?></h4></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <form action="pagar.php" method="post">
                                    <div class="alert alert-warning text-dark">
                                        <div class="form-group mb-2">
                                            <label for="email" class="fw-bold">Correo de contacto:</label>
                                            <input id="email" name="email" type="email" class="form-control" placeholder="ejemplo@correo.com" required>
                                        </div>
                                        <small class="form-text text-dark">
                                            Enviaremos la información de tu compra a este correo.
                                        </small>
                                    </div>
                                    <button class="btn btn-warning w-100 fw-bold" type="submit" name="btnAction" value="proceder">
                                        <i class="bi bi-credit-card-2-front-fill"></i> Proceder a pagar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Payment Instructions -->
                <div class="card bg-dark border-warning mt-4 shadow">
                    <div class="card-header bg-warning text-black">
                        <h4 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Instrucciones de Pago</h4>
                    </div>
                    <div class="card-body text-light">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-warning mb-3">Proceso de Pago</h5>
                                <ol class="list-group list-group-numbered list-group-flush">
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        Ingresa tu correo electrónico para recibir los detalles de tu compra
                                    </li>
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        Serás redirigido a nuestra plataforma de pago segura
                                    </li>
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        Completa el proceso de pago con tu método preferido
                                    </li>
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        Recibirás un correo con la confirmación de tu compra
                                    </li>
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-warning mb-3">Después del Pago</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                        Guarda tu ID de transacción para cualquier consulta
                                    </li>
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                        Revisa tu correo electrónico para los detalles de la compra
                                    </li>
                                    <li class="list-group-item bg-dark text-light border-warning">
                                        <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                        Si tienes alguna duda, contáctanos con tu ID de transacción
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning text-center text-dark">
                <i class="bi bi-cart-x-fill"></i> No hay productos en el carrito.
            </div>
        <?php } ?>
    </div>
</main>

<!-- Estilos adicionales -->
<style>
    .hover-row:hover {
        background-color: #1a1a1a;
        transition: background-color 0.3s ease;
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

    .form-control:focus {
        background-color: #fff;
        color: #000;
        border-color: #FFC800;
        box-shadow: 0 0 0 0.2rem rgba(255, 200, 0, 0.25);
    }
</style>

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php include 'templates/pie.php'; ?>