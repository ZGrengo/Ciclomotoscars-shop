<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>

<script src="https://www.paypal.com/sdk/js?client-id=Ac3yarg5W_DyUtvDzUVHVDoD8TpeAB_f3TOGU3JgyZsZTdYXYxEPOQgJx3X3hcYo_VYRo-esB0s2b22l">
//live id: AYuNLqRXgjcw3LFp-Viv0oW0s2NrdWxnydyS-PCb6-5j8Jgd5xAvDxniHGWislkXbyD5r0TAaKLBG9Bx
</script>
<?php
if($_POST){

    $total=0;
    $SID=session_id();
    $Correo=$_POST['email'];


    foreach($_SESSION['CARRITO'] as $indice=>$producto){

        $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);

    }
        $sentencia=$pdo->prepare("INSERT INTO `tblventas` 
                                (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
        VALUES (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
        
        $sentencia->bindParam(":ClaveTransaccion",$SID);
        $sentencia->bindParam(":Correo",$Correo);
        $sentencia->bindParam(":Total",$total);
        $sentencia->execute();
        $idVenta=$pdo->lastInsertId();

//Informacion de venta enviada a la base de datos
    foreach($_SESSION['CARRITO'] as $indice=>$producto){

        $sentencia=$pdo->prepare ("INSERT INTO 
        `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
        VALUES (NULL,:IDVENTA,:IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");

        $sentencia->bindParam(":IDVENTA",$idVenta);
        $sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
        $sentencia->execute();
    }
}
?>



<div class="jumbotron text-center">
    <h1 class="display-4">Paso final!</h1>
    <hr class="my-4">
    <p class="lead">Estas a punto de pagar con paypal la siguiente cantidad: 
        <h4><?php echo number_format($total,2); ?> $</h4>
    </p>
    <div id="paypal-button-container"></div>
    <p>El pedido podra ser retirado en los siguientes dias habiles <br/>
    <strong>(Para dudas o consultas: ciclomotoscar@gmail.com)</strong>
    </p>
    
</div>

<script>
      paypal.Buttons({
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?php echo $total; ?>'
              },
              custom:"<?php echo $SID;?>#<?php echo openssl_encrypt($idVenta, COD, KEY); ?>"
            }]
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
              console.log(details);
              
          });
        }
      }).render('#paypal-button-container'); // Display payment options on your web page
    </script>


<?php
include 'templates/pie.php';
?>