<?php
require_once __DIR__ . '/../global/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="global/styles.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
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
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
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