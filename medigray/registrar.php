<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Medigray</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .card0 {
            box-shadow: 0px 4px 8px 0px #757575;
            border-radius: 0px;
        }

        .card2 {
            margin: 0px 40px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .image {
            width: 100%;
            height: auto;
        }

        .btn-blue {
            background-color: #1A73E8;
            color: #fff;
            border-radius: 20px;
        }

        .btn-blue:hover {
            background-color: #0d5bd9;
        }

        .bg-blue {
            background-color: #1A73E8;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <!-- Imagen lateral -->
                <div class="col-lg-6">
                    <div class="card1 pb-5 text-center">
                        <img src="images/Logo_medigray.png" class="logo mb-5">
                        <img src="images/inicio.jpg" class="image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">Registro de Usuario</h6>
                        </div>

                        <?php
                        if (isset($_POST["txtMensaje"])) {
                            echo '<div class="alert alert-warning text-center">' . $_POST["txtMensaje"] . '</div>';
                        }
                        ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="txtNombre" placeholder="Nombre completo"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" class="form-control" name="txtEmail" placeholder="usuario@gmail.com"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="txtTelefono" placeholder="12345678"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="txtContrasena"
                                    placeholder="Contraseña" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="btnRegistrarUsuario"
                                    class="btn btn-blue btn-block">Registrar</button>
                            </div>
                        </form>

                        <div class="row px-3 mt-3">
                            <small>¿Ya tienes cuenta? <a href="inicio.php">Inicia sesión</a></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-3 text-white">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2">&copy; Medigray. Todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>