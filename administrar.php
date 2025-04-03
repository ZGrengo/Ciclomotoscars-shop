<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
<br/>
<div class="row">
        <?php
        
            $sentencia=$pdo->prepare("SELECT * FROM `tblproductos`");
            $sentencia->execute();
            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
        ?>
        <?php foreach($listaProductos as $producto){  ?>
            <div class="col-3">
                <div class="card">
                    <img 
                    title="<?php echo $producto['Nombre'];?>"
                    class="card-img-top" 
                    src="<?php echo $producto['Imagen'];?>" 
                    alt="<?php echo $producto['Nombre'];?>"
                    
                    data-toggle="popover"
                    data-trigger="hover"
                    data-content="<?php echo $producto['Descripcion'];?>"
                    height="317px"
                    >
                    <div class="card-body">
                        <span><?php echo $producto['Nombre'];?></span>
                        <h5 class="card-title"><?php echo $producto['Precio'];?>BsS</h5>

                    <form action="editar.php" method="post">

                    <input type="hidden" name="id" id="id" value="<?php echo ($producto['ID']);?>">
                    <input type="input" name="nombre" id="nombre" value="<?php echo ($producto['Nombre']);?>">
                    <input type="input" name="precio" id="precio" value="<?php echo ($producto['Precio']);?>">
                    <input type="input" name="cantidad" id="cantidad" value="<?php echo ($producto['Cantidad']);?>">

                    <button class="btn btn-primary" 
                        name="btnAction" 
                        value="Editar" 
                        type="submit">
                            Editar
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