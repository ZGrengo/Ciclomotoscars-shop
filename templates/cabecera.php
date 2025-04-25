<?php
require_once __DIR__ . '/../global/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="global/styles.css">
    <style>
        html, body {
            height: 100%;
            background-color: #000 !important;
        }
        body {
            display: flex;
            flex-direction: column;
            color: #fff;
        }
        main {
            flex: 1 0 auto;
        }
        .navbar {
            padding: 0.5rem 2rem;
        }
        .navbar-brand {
            margin-right: 2rem;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .nav-item {
            margin: 0 0.5rem;
        }
        .navbar-dark .navbar-nav .nav-link {
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #000;
            background-color: #fff;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top justify-content-between" id="barra" style="background-color: #111111;">
        <a class="navbar-brand" href="landing.php"><img src="archivos/img/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#my-nav" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Productos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="mostrarCarrito.php">Carrito<?php echo (!empty($_SESSION['CARRITO'])) ? '(' . count($_SESSION['CARRITO']) . ')' : ''; ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="administrar.php">Administracion</a>
                </li>
            </ul>
        </div>
    </nav>
    <br/>
    <br/>
    <br/>
    <main>
        <div class="container">