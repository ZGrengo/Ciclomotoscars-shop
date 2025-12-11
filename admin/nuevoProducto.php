<?php
include '../global/config.php';
include '../global/conexion.php';
include '../templates/cabecera.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = $_POST['Nombre'];
        $precio = $_POST['Precio'];
        $cantidad = $_POST['Cantidad'];
        $descripcion = $_POST['Descripcion'];
        $imagen = $_POST['Imagen'];
        $categoria = $_POST['Categoria'];

        $sentencia = $pdo->prepare("INSERT INTO tblproductos (Nombre, Precio, Cantidad, Descripcion, Imagen, Categoria) 
                                  VALUES (:nombre, :precio, :cantidad, :descripcion, :imagen, :categoria)");
        
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':precio', $precio);
        $sentencia->bindParam(':cantidad', $cantidad);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':imagen', $imagen);
        $sentencia->bindParam(':categoria', $categoria);
        
        $sentencia->execute();
        
        // Redirect to admin page with success message
        header("Location: administrar.php?mensaje=Producto agregado exitosamente");
        exit();
    } catch (PDOException $e) {
        $error = "Error al agregar el producto: " . $e->getMessage();
    }
}
?>

<main class="bg-black min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card bg-dark border-warning shadow-lg rounded-4">
                    <div class="card-header bg-warning text-black rounded-top-4">
                        <h3 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Agregar Nuevo Producto</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-warning text-dark">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="nuevoProducto.php" method="post" novalidate>
                            <div class="mb-3">
                                <label for="Nombre" class="form-label text-warning">Nombre del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-warning"><i class="bi bi-box-seam"></i></span>
                                    <input type="text" class="form-control bg-dark text-light border-warning" id="Nombre" name="Nombre" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Categoria" class="form-label text-warning">Categoría</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-warning"><i class="bi bi-tags-fill"></i></span>
                                    <select class="form-select bg-dark text-light border-warning" id="Categoria" name="Categoria" required>
                                        <option value="">Seleccione una categoría</option>
                                        <option value="Coche">Coche</option>
                                        <option value="Motocicleta">Motocicleta</option>
                                        <option value="Bicicleta">Bicicleta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Precio" class="form-label text-warning">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-warning">$</span>
                                    <input type="number" class="form-control bg-dark text-light border-warning" id="Precio" name="Precio" step="0.01" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Cantidad" class="form-label text-warning">Cantidad en Stock</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-warning"><i class="bi bi-123"></i></span>
                                    <input type="number" class="form-control bg-dark text-light border-warning" id="Cantidad" name="Cantidad" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Descripcion" class="form-label text-warning">Descripción</label>
                                <textarea class="form-control bg-dark text-light border-warning" id="Descripcion" name="Descripcion" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="Imagen" class="form-label text-warning">URL de la Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-warning border-warning"><i class="bi bi-image-fill"></i></span>
                                    <input type="url" class="form-control bg-dark text-light border-warning" id="Imagen" name="Imagen" required>
                                </div>
                                <div class="form-text text-warning">Ej: archivos/img/productos/nombre-imagen.jpg</div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="administrar.php" class="btn btn-outline-warning">
                                    <i class="bi bi-x-circle-fill me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle-fill me-1"></i>Agregar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #1a1a1a;
        border-color: #FFC800;
        box-shadow: 0 0 0 0.25rem rgba(255, 200, 0, 0.3);
        color: #fff;
    }

    .input-group-text {
        border-color: #FFC800;
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
    }

    .btn-outline-warning:hover {
        background-color: #FFC800;
        color: #000;
    }

    .card {
        border-radius: 1rem;
    }
</style>

<?php include '../templates/pie.php'; ?>
