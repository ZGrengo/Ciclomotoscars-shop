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
<div class="bg-black py-4 mb-5">
    <div class="container">
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                $chunks = array_chunk($listaProductos, 3);
                foreach($chunks as $index => $chunk) { ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="row">
                            <?php foreach($chunk as $producto) { ?>
                                <div class="col-md-4">
                                    <div class="card bg-dark border-warning h-100" onclick="window.location.href='index.php'" style="cursor: pointer;">
                                        <div class="card-body p-0">
                                            <div class="carousel-image-container" style="height: 250px; overflow: hidden;">
                                                <img class="d-block mx-auto h-100 object-fit-contain" src="<?php echo htmlspecialchars($producto['Imagen']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre']); ?>" style="max-width: 80%;">
                                            </div>
                                            <div class="card-footer bg-dark border-warning text-center">
                                                <h5 class="text-warning mb-0"><?php echo htmlspecialchars($producto['Nombre']); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<!-- About Us Section -->
<section class="py-5" style="background-color: #111111;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h2 class="display-4 mb-4">Sobre Nosotros</h2>
                <p class="lead text-warning">Bienvenidos a nuestra tienda de ciclomotores</p>
                <div class="text-left text-light">
                    <p class="mb-4">En Ciclomotores Plus, nos apasiona brindarte la mejor experiencia sobre ruedas. Con más de 10 años de trayectoria, nos hemos consolidado como una tienda líder en la venta de ciclomotores, motocicletas y bicicletas de alta calidad.</p>
                    
                    <p class="mb-4">Nuestro compromiso es ofrecer productos confiables, innovadores y accesibles, acompañados siempre de un servicio cercano y personalizado. Cada uno de nuestros clientes forma parte de esta gran comunidad que comparte el amor por la velocidad, la aventura y la libertad.</p>
                    
                    <p class="mb-4">Trabajamos día a día para seleccionar las mejores marcas y los modelos más destacados del mercado, adaptándonos a tus necesidades y a las nuevas tendencias.</p>
                    
                    <p class="mb-0">¡Te invitamos a ser parte de nuestra familia de más de 500 clientes felices! Tu próxima aventura comienza aquí.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-5" style="background-color: #111111;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <h2 class="display-4 text-warning" id="clientes">0+</h2>
                <p class="lead text-white">Clientes felices</p>
            </div>
            <div class="col-md-4 mb-4">
                <h2 class="display-4 text-warning" id="experiencia">0</h2>
                <p class="lead text-white">Años de experiencia</p>
            </div>
            <div class="col-md-4 mb-4">
                <h2 class="display-4 text-warning" id="productos">0+</h2>
                <p class="lead text-white">Productos disponibles</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h2 class="display-4 mb-4">Contáctanos</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 bg-dark border-warning">
                            <div class="card-body text-white">
                                <i class="fas fa-map-marker-alt fa-2x mb-3 text-warning"></i>
                                <h5 class="card-title">Ubicación</h5>
                                <p class="card-text">Av. Principal #123<br>Ciudad, Estado<br>Código Postal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 bg-dark border-warning">
                            <div class="card-body text-white">
                                <i class="fas fa-clock fa-2x mb-3 text-warning"></i>
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
                        <div class="card h-100 bg-dark border-warning">
                            <div class="card-body text-white">
                                <i class="fas fa-phone fa-2x mb-3 text-warning"></i>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerText = Math.floor(progress * (end - start) + start) + (id !== 'experiencia' ? '+' : '');
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        animateValue("clientes", 0, 500, 2000);
        animateValue("experiencia", 0, 10, 2000);
        animateValue("productos", 0, 100, 2000);
    });
</script>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        background-color: #000;
        color: #fff;
    }

    .navbar {
        border-bottom: 2px solid #FFC800;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: #fff;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        color: #000;
        background-color: #fff;
        border-radius: 4px;
    }

    .carousel-image-container {
        position: relative;
        background-color: #000;
        display: flex;
        justify-content: center;
        align-items: center;
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

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid #FFC800;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(255, 200, 0, 0.3);
    }

    .display-4 {
        font-weight: bold;
        color: #fff;
    }

    section {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }

    .bg-dark .carousel-indicators li {
        background-color: #FFC800;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .text-warning {
        color: #FFC800 !important;
    }

    footer {
        border-top: 2px solid #FFC800;
    }

    .card-footer {
        padding: 1rem;
    }
</style>

<?php
include 'templates/pie.php';
?> 