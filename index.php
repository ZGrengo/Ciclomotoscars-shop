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

        <div class="row">
        <?php
        
            $sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
            $sentencia->execute();
            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
        ?>
        <?php foreach($listaProductos as $producto){  ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <div class="card-img-container" style="height: 200px; overflow: hidden;">
                        <img 
                        title="<?php echo $producto['Nombre'];?>"
                        class="card-img-top img-fluid h-100 w-100 object-fit-cover" 
                        src="<?php echo $producto['Imagen'];?>" 
                        alt="<?php echo $producto['Nombre'];?>"
                        data-toggle="popover"
                        data-trigger="hover"
                        data-content="<?php echo $producto['Descripcion'];?>"
                        >
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="card-title"><?php echo $producto['Nombre'];?></span>
                        <h5 class="card-text"><?php echo $producto['Precio'];?>$</h5>

                    <form action="" method="post">

                    <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY);?>">
                    <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD,KEY);?>">
                    <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD,KEY);?>">
                    <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY);?>">

                    <button class="btn btn-primary" 
                        name="btnAction" 
                        value="Agregar" 
                        type="submit">
                            Agregar al carrito
                        </button>

                    </form>


                    </div>
                </div>
            </div>     
            
        <?php  }   ?>

        </div>
    </div>
            <script>
                $(function () {
                    $('[data-toggle="popover"]').popover()
                })
            </script>
<?php
include 'templates/pie.php';
?>