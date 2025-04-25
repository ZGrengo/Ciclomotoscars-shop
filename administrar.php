<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';

// Check for success message from nuevoProducto.php
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>

<main class="bg-black py-5">
    <div class="container">
        <?php if (isset($mensaje) && $mensaje != "") { ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php } ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-warning display-4">Administración de Productos</h1>
            <div>
                <a href="nuevoProducto.php" class="btn btn-warning me-2">
                    <i class="fas fa-plus me-1"></i> Agregar Producto
                </a>
                <button id="editarTodos" class="btn btn-outline-warning">
                    <i class="fas fa-edit me-1"></i> Editar Todos
                </button>
            </div>
        </div>

        <div class="row">
            <?php
            $sentencia = $pdo->prepare("SELECT * FROM `tblproductos`");
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($listaProductos as $producto) { ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card bg-dark border-warning shadow-lg h-100">
                    <div class="overflow-hidden rounded-top">
                        <img 
                            title="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                            class="card-img-top img-hover"
                            src="<?php echo htmlspecialchars($producto['Imagen']); ?>"
                            alt="<?php echo htmlspecialchars($producto['Nombre']); ?>"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover"
                            data-bs-content="<?php echo htmlspecialchars($producto['Descripcion']); ?>"
                            height="250px"
                        >
                    </div>
                    <div class="card-body d-flex flex-column">
                        <form action="editar.php" method="post" class="producto-form">
                            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($producto['ID']); ?>">

                            <div class="form-group mb-2">
                                <label class="text-warning fw-semibold">Nombre</label>
                                <input type="text" class="form-control bg-dark text-light border-warning" name="Nombre"
                                    value="<?php echo htmlspecialchars($producto['Nombre']); ?>" required readonly>
                            </div>

                            <div class="form-group mb-2">
                                <label class="text-warning fw-semibold">Precio</label>
                                <input type="number" class="form-control bg-dark text-light border-warning" name="Precio"
                                    value="<?php echo htmlspecialchars($producto['Precio']); ?>" step="0.01" required readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-warning fw-semibold">Cantidad</label>
                                <input type="number" class="form-control bg-dark text-light border-warning" name="Cantidad"
                                    value="<?php echo htmlspecialchars($producto['Cantidad'] ?? 0); ?>" required readonly>
                            </div>

                            <div class="btn-group w-100">
                                <button class="btn btn-outline-warning editar-producto" type="button">
                                    <i class="fas fa-unlock"></i> Editar
                                </button>
                                <button class="btn btn-warning actualizar-producto" type="submit" style="display: none;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>

<style>
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

    .btn-outline-warning {
        color: #FFC800;
        border-color: #FFC800;
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover {
        background-color: #FFC800;
        color: #000;
    }

    .form-control:focus {
        background-color: #1a1a1a;
        border-color: #FFC800;
        box-shadow: 0 0 0 0.25rem rgba(255, 200, 0, 0.25);
        color: #fff;
    }

    .form-control:read-only {
        background-color: #1a1a1a;
        border-color: #333;
    }

    .form-control:read-only:focus {
        border-color: #333;
        box-shadow: none;
    }

    .alert-warning {
        background-color: rgba(255, 200, 0, 0.1);
        border-color: #FFC800;
        color: #FFC800;
    }

    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editarTodosBtn = document.getElementById('editarTodos');

        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
            new bootstrap.Popover(el);
        });

        document.querySelectorAll('.editar-producto').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('form');
                toggleEditable(form, true);
            });
        });

        editarTodosBtn.addEventListener('click', function () {
            const allForms = document.querySelectorAll('.producto-form');
            const isEditing = editarTodosBtn.classList.contains('editing');

            allForms.forEach(form => toggleEditable(form, !isEditing));

            editarTodosBtn.classList.toggle('editing');
            editarTodosBtn.classList.toggle('btn-outline-warning');
            editarTodosBtn.classList.toggle('btn-outline-danger');
            editarTodosBtn.innerHTML = isEditing
                ? '<i class="fas fa-edit me-1"></i> Editar Todos'
                : '<i class="fas fa-times me-1"></i> Cancelar';
        });

        function toggleEditable(form, editable) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"]');
            const editBtn = form.querySelector('.editar-producto');
            const saveBtn = form.querySelector('.actualizar-producto');

            inputs.forEach(input => input.readOnly = !editable);
            if (editable) {
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';
                inputs[0].focus();
            } else {
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';
            }
        }
    });
</script>

<?php include 'templates/pie.php'; ?>