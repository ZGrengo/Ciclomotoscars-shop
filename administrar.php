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
        <h2 class="text-center mb-4">Administración de Productos</h2>
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
                            <form action="editar.php" method="post" class="w-100">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['ID']);?>">
                                
                                <div class="form-group">
                                    <label for="nombre_<?php echo $producto['ID'];?>">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Nombre']);?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="precio_<?php echo $producto['ID'];?>">Precio</label>
                                    <input type="number" class="form-control" name="precio" id="precio_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Precio']);?>" step="0.01" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cantidad_<?php echo $producto['ID'];?>">Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" id="cantidad_<?php echo $producto['ID'];?>" 
                                        value="<?php echo htmlspecialchars($producto['Cantidad'] ?? 0);?>" required>
                                </div>

                                <button class="btn btn-primary w-100 mt-2" 
                                    name="btnAction" 
                                    value="Editar" 
                                    type="submit">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
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
            
            // Form validation
            $('form').on('submit', function(e) {
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