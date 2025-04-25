<?php
include '../global/config.php';
checkAdminAccess();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .admin-card {
            background-color: #1a1a1a;
            border: 1px solid #FFC800;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 200, 0, 0.1);
        }
        .nav-link {
            color: #fff;
        }
        .nav-link:hover {
            color: #FFC800;
        }
        .nav-link.active {
            background-color: #FFC800 !important;
            color: #000 !important;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                <div class="admin-card p-3 mb-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill text-warning" style="font-size: 3rem;"></i>
                        <h4 class="text-warning mt-3">Panel Admin</h4>
                    </div>
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                        <a class="nav-link" href="productos.php">
                            <i class="bi bi-box"></i> Productos
                        </a>
                        <a class="nav-link" href="pedidos.php">
                            <i class="bi bi-cart-check"></i> Pedidos
                        </a>
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="admin-card p-4">
                    <h2 class="text-warning mb-4">Bienvenido al Panel de Administración</h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="admin-card p-3 h-100">
                                <h5 class="text-warning">
                                    <i class="bi bi-box"></i> Productos
                                </h5>
                                <p class="mb-0">Administra los productos de la tienda</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="admin-card p-3 h-100">
                                <h5 class="text-warning">
                                    <i class="bi bi-cart-check"></i> Pedidos
                                </h5>
                                <p class="mb-0">Gestiona los pedidos de los clientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 