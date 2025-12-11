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

        <?php if (!empty($_SESSION['CARRITO'])) { 
            $total = 0;
            foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                $total += ($producto['PRECIO'] * $producto['CANTIDAD']);
            }
        ?>
            <!-- Card View for All Screens -->
            <div class="cart-cards-container">
                <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                    <div class="card bg-dark border-warning mb-3 cart-item-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-3 text-center mb-3 mb-md-0">
                                    <img src="<?php echo isset($producto['IMAGEN']) && !empty($producto['IMAGEN']) ? htmlspecialchars($producto['IMAGEN']) : 'archivos/img/logo.png'; ?>" 
                                         alt="Producto" class="img-fluid rounded cart-product-image"
                                         onerror="this.src='archivos/img/logo.png'">
                                </div>
                                <div class="col-12 col-md-9">
                                    <h5 class="text-warning mb-3"><?php echo $producto['NOMBRE']; ?></h5>
                                    <div class="row">
                                        <div class="col-6 col-md-4 mb-2">
                                            <div class="d-flex flex-column">
                                                <span class="text-light small">Cantidad:</span>
                                                <span class="text-warning fw-bold"><?php echo $producto['CANTIDAD']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 mb-2">
                                            <div class="d-flex flex-column">
                                                <span class="text-light small">Precio unitario:</span>
                                                <span class="text-warning">$<?php echo $producto['PRECIO']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                                            <div class="d-flex flex-column">
                                                <span class="text-light small fw-bold">Subtotal:</span>
                                                <span class="text-warning fw-bold fs-5">$<?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="" method="post" class="mt-3">
                                        <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                        <button class="btn btn-outline-danger btn-sm" type="submit" name="btnAction" value="Eliminar">
                                            <i class="bi bi-trash-fill"></i> Eliminar del carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <!-- Total and Payment Form -->
                <div class="card bg-dark border-warning mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-warning mb-0">Total:</h4>
                            <h4 class="text-warning mb-0">$<?php echo number_format($total, 2); ?></h4>
                        </div>
                        <form action="pagar.php" method="post">
                            <div class="alert alert-warning text-dark mb-3">
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
                    </div>
                </div>
            </div>

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

    /* Cart card styles */
    .cart-item-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 10px;
    }

    .cart-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 200, 0, 0.2);
    }

    .cart-product-image {
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
    }

    /* Desktop styles */
    @media (min-width: 768px) {
        .cart-cards-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .cart-item-card .card-body {
            padding: 1.5rem;
        }

        .cart-product-image {
            max-width: 180px;
            max-height: 180px;
        }
    }

    /* Tablet styles */
    @media (min-width: 509px) and (max-width: 767px) {
        .cart-product-image {
            max-width: 120px;
            max-height: 120px;
        }
    }

    /* Mobile responsive styles */
    @media (max-width: 508px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .cart-item-card {
            border-radius: 8px;
        }

        .cart-item-card .card-body {
            padding: 1rem;
        }

        .cart-product-image {
            max-width: 100%;
            max-height: 200px;
        }

        h2 {
            font-size: 1.5rem;
        }

        h4, h5 {
            font-size: 1.1rem;
        }
    }
</style>

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php include 'templates/pie.php'; ?>