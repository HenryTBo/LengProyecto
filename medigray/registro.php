<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
                <!-- Formulario Register -->
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">Registrarse</h6>
                        </div>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="txtNombre">Nombre Completo</label>
                                <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                                    placeholder="Ingrese su nombre completo" required>
                            </div>

                            <div class="form-group">
                                <label for="txtEmail">Correo Electrónico</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail"
                                    placeholder="usuario@gmail.com" required>
                            </div>

                            <div class="form-group">
                                <label for="txtTelefono">Teléfono</label>
                                <input type="tel" class="form-control" id="txtTelefono" name="txtTelefono"
                                    placeholder="Ingrese su número de teléfono" required>
                            </div>

                            <div class="form-group">
                                <label for="txtContrasena">Contraseña</label>
                                <input type="password" class="form-control" id="txtContrasena" name="txtContrasena"
                                    placeholder="Ingrese su contraseña" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="btnRegistrarUsuario"
                                    class="btn btn-blue btn-block">Registrarse</button>
                            </div>

                            <div class="text-center">
                                <small class="font-weight-bold">¿Ya tienes cuenta?
                                    <a href="Inicio.php" class="text-danger">Iniciar Sesión</a>
                                </small>
                            </div>
                        </form>
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