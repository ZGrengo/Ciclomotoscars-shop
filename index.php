<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';

// Initialize cart message
$cartMessage = '';

// Check if an item was added
if(isset($_POST['btnAction']) && $_POST['btnAction'] == "Agregar" && !isset($_SESSION['CARRITO'])) {
    $cartMessage = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>¡Producto agregado!</strong> El producto ha sido añadido al carrito.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

// Handle category filter
$categoriaSeleccionada = $_GET['categoria'] ?? 'Todos';

$query = "SELECT * FROM tblproductos";
if ($categoriaSeleccionada !== 'Todos') {
    $query .= " WHERE Categoria = :categoria";
}

$sentencia = $pdo->prepare($query);
if ($categoriaSeleccionada !== 'Todos') {
    $sentencia->bindParam(':categoria', $categoriaSeleccionada, PDO::PARAM_STR);
}
$sentencia->execute();
$listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Get all unique categories
$categoriasQuery = $pdo->prepare("SELECT DISTINCT Categoria FROM tblproductos WHERE Categoria IS NOT NULL AND Categoria != ''");
$categoriasQuery->execute();
$categorias = $categoriasQuery->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="bg-black py-5">
    <div class="container">
        <h1 class="text-warning text-center mb-5 display-4">Nuestros Productos</h1>
        
        <?php if($cartMessage != '') echo $cartMessage; ?>

        <!-- Filtro por categoría -->
        <div class="text-center mb-5">
            <form method="GET" class="d-inline-block">
                <select name="categoria" class="form-control bg-dark text-warning border-warning" onchange="this.form.submit()">
                    <option value="Todos" <?= $categoriaSeleccionada == 'Todos' ? 'selected' : '' ?>>Todos</option>
                    <?php foreach($categorias as $categoria): ?>
                        <option value="<?= $categoria ?>" <?= $categoriaSeleccionada == $categoria ? 'selected' : '' ?>>
                            <?= $categoria ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        
        <div class="row">
            <?php if (count($listaProductos) > 0): ?>
                <?php foreach ($listaProductos as $producto) { 
                    // Get quantity from cart if exists
                    $quantity = 0;
                    if(isset($_SESSION['CARRITO'])) {
                        foreach($_SESSION['CARRITO'] as $item) {
                            if($item['ID'] == $producto['ID']) {
                                $quantity = $item['CANTIDAD'];
                                break;
                            }
                        }
                    }
                ?>
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
                                <?php if($quantity > 0): ?>
                                    <div class="mt-2 d-flex justify-content-center align-items-center">
                                        <form action="" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                            <input type="hidden" name="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                                            <input type="hidden" name="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                                            <button type="submit" name="btnAction" value="Menos" class="btn btn-sm btn-warning mx-1">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="badge badge-warning mx-2"><?php echo $quantity; ?></span>
                                            <button type="submit" name="btnAction" value="Mas" class="btn btn-sm btn-warning mx-1">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-dark border-top border-warning text-center">
                                <form action="" method="post">
                                    <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                                    <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                                    <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                                    <input type="hidden" name="imagen" id="imagen" value="<?php echo openssl_encrypt($producto['Imagen'], COD, KEY); ?>">
                                    <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                                    <button class="btn btn-warning w-100" name="btnAction" value="Agregar" type="submit">Agregar al Carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-light">No hay productos disponibles en esta categoría.</p>
                </div>
            <?php endif; ?>
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

    .badge-warning {
        background-color: #FFC800;
        color: #000;
        font-size: 0.9rem;
        padding: 0.5em 1em;
        min-width: 2.5em;
    }

    .alert-warning {
        background-color: rgba(255, 200, 0, 0.1);
        border-color: #FFC800;
        color: #FFC800;
    }

    .alert-warning .close {
        color: #FFC800;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    select.form-control {
        width: 200px;
        display: inline-block;
    }
</style>

<?php include 'templates/pie.php'; ?>