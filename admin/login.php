<?php
include '../global/config.php';

// Check if already logged in
if (isset($_SESSION['esAdmin'])) {
    header('Location: index.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = $_POST['clave'] ?? '';
    
    if ($clave === ADMIN_KEY) {
        $_SESSION['esAdmin'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error = "Clave incorrecta";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #1a1a1a;
            border: 1px solid #FFC800;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 200, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }
        .form-control {
            background-color: #2a2a2a;
            border: 1px solid #FFC800;
            color: #fff;
        }
        .form-control:focus {
            background-color: #2a2a2a;
            border-color: #FFC800;
            box-shadow: 0 0 0 0.25rem rgba(255, 200, 0, 0.25);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-card p-4">
        <div class="text-center mb-4">
            <i class="bi bi-shield-lock-fill text-warning" style="font-size: 3rem;"></i>
            <h2 class="text-warning mt-3">Acceso Administrador</h2>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="clave" class="form-label">Clave de acceso</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Acceder</button>
        </form>

        <div class="text-center mt-3">
            <a href="../index.php" class="text-warning text-decoration-none">
                <i class="bi bi-arrow-left"></i> Volver a la tienda
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 