<?php
include 'global/config.php';
include 'global/conexion.php';
include 'templates/cabecera.php';

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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0">Agregar Nuevo Producto</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="nuevoProducto.php" method="post">
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="Categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="Categoria" name="Categoria" required>
                                <option value="">Seleccione una categoría</option>
                                <option value="Coche">Coche</option>
                                <option value="Motocicleta">Motocicleta</option>
                                <option value="Bicicleta">Bicicleta</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="Precio" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="Precio" name="Precio" step="0.01" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="Cantidad" class="form-label">Cantidad en Stock</label>
                            <input type="number" class="form-control" id="Cantidad" name="Cantidad" required>
                        </div>

                        <div class="mb-3">
                            <label for="Descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Imagen" class="form-label">URL de la Imagen</label>
                            <input type="url" class="form-control" id="Imagen" name="Imagen" required>
                            <div class="form-text">Ingrese la URL completa de la imagen (ej: https://ejemplo.com/imagen.jpg)</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="administrar.php" class="btn btn-outline-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Agregar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/pie.php'; ?> 