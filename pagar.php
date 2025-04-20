<?php
require_once __DIR__ . '/global/init.php';
include 'templates/cabecera.php';

// Initialize variables
$total = 0;
$SID = session_id();

// Calculate total from cart
if(isset($_SESSION['CARRITO']) && !empty($_SESSION['CARRITO'])) {
    foreach($_SESSION['CARRITO'] as $indice=>$producto) {
        $total += ($producto['PRECIO'] * $producto['CANTIDAD']);
    }
}

if($_POST && !empty($_SESSION['CARRITO'])) {
    $Correo = $_POST['email'];

    $sentencia = $pdo->prepare("INSERT INTO `tblventas` 
                            (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
    VALUES (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
    
    $sentencia->bindParam(":ClaveTransaccion", $SID);
    $sentencia->bindParam(":Correo", $Correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->execute();
    $idVenta = $pdo->lastInsertId();

    // Informacion de venta enviada a la base de datos
    foreach($_SESSION['CARRITO'] as $indice=>$producto) {
        $sentencia = $pdo->prepare("INSERT INTO 
        `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
        VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");

        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $sentencia->execute();
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 200px);">
    <div class="jumbotron text-center w-100" style="max-width: 600px;">
        <h1 class="display-4">Paso final!</h1>
        <hr class="my-4">
        <?php if(empty($_SESSION['CARRITO'])): ?>
            <div class="alert alert-warning">
                No hay productos en el carrito. Por favor, agregue productos antes de proceder al pago.
            </div>
        <?php else: ?>
            <p class="lead">Estas a punto de pagar con paypal la siguiente cantidad:</p>
            <h4 class="mb-4"><?php echo number_format($total, 2); ?> $</h4>
            <div id="paypal-button-container" class="mb-4"></div>
            <p class="mb-0">El pedido podra ser retirado en los siguientes dias habiles</p>
            <p class="mb-0"><strong>(Para dudas o consultas: ciclomotoscar@gmail.com)</strong></p>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($_SESSION['CARRITO'])): ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_KEY; ?>"></script>
<script>
paypal.Buttons({
  createOrder: function(data, actions) {
    return actions.order.create({
      purchase_units: [{
        amount: {
          value: '<?php echo $total; ?>'
        },
        custom: "<?php echo $SID; ?>#<?php echo isset($idVenta) ? openssl_encrypt($idVenta, COD, KEY) : ''; ?>"
      }]
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      console.log('Payment details:', details);
      
      // Send order data to server
      return fetch('procesar_pago.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          orderID: data.orderID,
          details: details,
          total: <?php echo $total; ?>,
          email: '<?php echo isset($Correo) ? $Correo : ''; ?>',
          sessionID: '<?php echo $SID; ?>'
        })
      })
      .then(function(response) {
        console.log('Response status:', response.status);
        if (!response.ok) {
          return response.text().then(function(text) {
            console.error('Server response:', text);
            throw new Error('Server error: ' + response.status);
          });
        }
        return response.json();
      })
      .then(function(data) {
        console.log('Response data:', data);
        if (data.success) {
          window.location.href = "completado.php?orderID=" + data.orderID;
        } else {
          console.error('Payment error:', data.message);
          alert('Error al procesar el pago: ' + data.message);
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
        alert('Error al procesar el pago. Por favor, contacte al soporte.');
      });
    });
  },
  onError: function(err) {
    console.error('PayPal error:', err);
    alert('Error con PayPal: ' + err.message);
  }
}).render('#paypal-button-container');
</script>
<?php endif; ?>
</main>
<?php
include 'templates/pie.php';
?>