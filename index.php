<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>

<main class="bg-black py-5">
    <div class="container">
        <h1 class="text-warning text-center mb-5 display-4">Nuestros Productos</h1>
        <div class="row">
            <?php
            $sentencia = $pdo->prepare("SELECT * FROM tblproductos");
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($listaProductos as $producto) { ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card bg-dark border-warning shadow-lg h-100">
                        <div class="overflow-hidden rounded-top">
                            <img 
                                title="<?php echo $producto['Nombre']; ?>"
                                alt="<?php echo $producto['Nombre']; ?>"
                                class="card-img-top img-hover"
                                src="<?php echo $producto['Imagen']; ?>"
                                data-toggle="popover"
                                data-trigger="hover"
                                data-content="<?php echo $producto['Descripcion']; ?>"
                                height="250px"
                            >
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title text-warning"><?php echo $producto['Nombre']; ?></h5>
                            <p class="card-text text-light small"><?php echo $producto['Descripcion']; ?></p>
                            <h5 class="text-warning mt-auto">$<?php echo $producto['Precio']; ?></h5>
                        </div>
                        <div class="card-footer bg-dark border-top border-warning text-center">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                <input type="hidden" name="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                                <input type="hidden" name="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                                <input type="hidden" name="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                                <button class="btn btn-warning w-100" name="btnAccion" value="Agregar" type="submit">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<style>
    html, body {
        background-color: #000 !important;
        height: 100%;
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 1rem;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(255, 200, 0, 0.2);
    }

    .img-hover {
        object-fit: cover;
        transition: transform 0.4s ease;
        width: 100%;
    }

    .img-hover:hover {
        transform: scale(1.05);
    }

    .btn-warning {
        background-color: #FFC800;
        border-color: #FFC800;
        color: #000;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e6b400;
        border-color: #e6b400;
        color: #000;
    }

    .text-light {
        color: #e0e0e0 !important;
    }

    h1.display-4 {
        font-weight: 700;
        letter-spacing: 1px;
    }
</style>

<?php include 'templates/pie.php'; ?>