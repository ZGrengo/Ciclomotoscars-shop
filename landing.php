<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';

// Get products for carousel
$sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
$sentencia->execute();
$listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Carousel -->
<div class="bg-dark py-4">
    <div class="container">
        <div id="productCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach($listaProductos as $index => $producto){ ?>
                    <li data-target="#productCarousel" data-slide-to="<?php echo $index; ?>" <?php echo $index === 0 ? 'class="active"' : ''; ?>></li>
                <?php } ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach($listaProductos as $index => $producto){ ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="carousel-image-container" style="height: 300px; overflow: hidden;">
                            <a href="index.php" class="d-block w-100 h-100">
                                <img class="d-block mx-auto h-100 object-fit-contain" src="<?php echo htmlspecialchars($producto['Imagen']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre']); ?>">
                            </a>
                            <div class="carousel-caption d-none d-md-block text-white">
                                <h3 class="text-warning"><?php echo htmlspecialchars($producto['Nombre']); ?></h3>
                                <p class="text-light"><?php echo htmlspecialchars($producto['Descripcion']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<!-- About Us Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 mb-4">Sobre Nosotros</h2>
                <p class="lead">Bienvenidos a nuestra tienda de ciclomotores</p>
                <div class="text-left">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 mb-4">Contáctanos</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                                <h5 class="card-title">Ubicación</h5>
                                <p class="card-text">Av. Principal #123<br>Ciudad, Estado<br>Código Postal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-clock fa-2x mb-3"></i>
                                <h5 class="card-title">Horarios</h5>
                                <p class="card-text">
                                    Lunes a Viernes: 9:00 - 18:00<br>
                                    Sábados: 10:00 - 14:00<br>
                                    Domingos: Cerrado
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-phone fa-2x mb-3"></i>
                                <h5 class="card-title">Contacto</h5>
                                <p class="card-text">
                                    Tel: (123) 456-7890<br>
                                    Email: info@ciclomotores.com<br>
                                    WhatsApp: +1 234 567 890
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        background-color: #f8f9fa;
    }

    .carousel-image-container {
        position: relative;
        background-color: #212529;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
    }

    .carousel-image-container img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.6);
        padding: 20px;
        border-radius: 10px;
    }

    .carousel-caption h3,
    .carousel-caption p {
        color: #fff;
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .card-body i {
        color: #e6e84e;
    }

    .display-4 {
        font-weight: bold;
        color: #343a40;
    }

    section {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }

    .bg-dark .carousel-indicators li {
        background-color: #e6e84e;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 2rem;
        height: 2rem;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }
</style>

</main>
<?php
include 'templates/pie.php';
?> 