<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br/>
    <?php if($mensaje!=""){?>
    <div class="container">
        <br>
        <div class="alert alert-success" role="alert">
            <?php echo $mensaje;?>
            <a href="mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
        </div>
    <?php }?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Administración de Productos</h2>
            <button id="editarTodos" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar Todos
            </button>
        </div>

        <div class="row">
            <?php
                $sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
                $sentencia->execute();
                $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach($listaProductos as $producto){  ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-container" style="height: 200px; overflow: hidden;">
                            <img 
                            title="<?php echo htmlspecialchars($producto['Nombre']);?>"
                            class="card-img-top img-fluid h-100 w-100 object-fit-cover" 
                            src="<?php echo htmlspecialchars($producto['Imagen']);?>" 
                            alt="<?php echo htmlspecialchars($producto['Nombre']);?>"
                            data-toggle="popover"
                            data-trigger="hover"
                            data-content="<?php echo htmlspecialchars($producto['Descripcion']);?>"
                            >
                        </div>
                        <div class="card-body d-flex flex-column">
                            <form action="editar.php" method="post" class="w-100 producto-form">
                                <input type="hidden" name="ID" value="<?php echo htmlspecialchars($producto['ID']);?>">
                                
                                <div class="form-group">
                                    <label for="nombre_<?php echo $producto['ID'];?>">Nombre</label>
                                    <input type="text" class="form-control" name="Nombre" id="nombre_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Nombre']);?>" required readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="precio_<?php echo $producto['ID'];?>">Precio</label>
                                    <input type="number" class="form-control" name="Precio" id="precio_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Precio']);?>" step="0.01" required readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cantidad_<?php echo $producto['ID'];?>">Cantidad</label>
                                    <input type="number" class="form-control" name="Cantidad" id="cantidad_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Cantidad'] ?? 0);?>" required readonly>
                                </div>

                                <div class="btn-group w-100">
                                    <button class="btn btn-warning editar-producto" type="button">
                                        <i class="fas fa-unlock"></i> Editar
                                    </button>
                                    <button class="btn btn-success actualizar-producto" type="submit" style="display: none;">
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>     
            <?php } ?>
        </div>
    </div>

    <script>
        $(function () {
            $('[data-toggle="popover"]').popover();
            
            // Handle individual product edit button
            $('.editar-producto').on('click', function(e) {
                const form = $(this).closest('form');
                toggleFormEdit(form, true);
            });

            // Handle edit all button
            $('#editarTodos').on('click', function() {
                const isEditing = $(this).hasClass('editing');
                $('.producto-form').each(function() {
                    toggleFormEdit($(this), !isEditing);
                });
                
                // Toggle button text and class
                if (!isEditing) {
                    $(this).html('<i class="fas fa-lock"></i> Cancelar Edición');
                    $(this).removeClass('btn-warning').addClass('btn-danger editing');
                } else {
                    $(this).html('<i class="fas fa-edit"></i> Editar Todos');
                    $(this).removeClass('btn-danger editing').addClass('btn-warning');
                }
            });

            // Function to toggle form edit state
            function toggleFormEdit(form, editable) {
                const inputs = form.find('input[type="text"], input[type="number"]');
                const editBtn = form.find('.editar-producto');
                const updateBtn = form.find('.actualizar-producto');

                inputs.prop('readonly', !editable);
                
                if (editable) {
                    editBtn.hide();
                    updateBtn.show();
                    inputs.first().focus();
                } else {
                    editBtn.show();
                    updateBtn.hide();
                }
            }

            // Form validation
            $('.producto-form').on('submit', function(e) {
                let isValid = true;
                $(this).find('input[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</main>
<?php
include 'templates/pie.php';
?>