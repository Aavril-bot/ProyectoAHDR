<?php
$alert = "";
session_start();
if (!empty($_SESSION['activa'])) {
    header('location:Cliente/inicio.php');
} else {
    if (!empty($_POST)) {
        //valida  que  correo y contraseña  estan vacios
        if (empty($_POST['correo']) || empty($_POST['contra'])) {
            $alert = '<div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Correo y/o contraseña  son obligatorios
                        </div>
                    </div>';
        } else { //cuando  si se  ingresen  datos
            require_once('Servidor/conexion.php');
            $usuario = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = mysqli_real_escape_string($conexion, $_POST['contra']);
            $query = mysqli_query(
                $conexion,
                "select * from usuarios where correo='$usuario' AND contra='$pass'"
            );
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                //creamos  variables de  tipo sesión  para  tener  los datos  disponibles
                $_SESSION['activa'] = true;
                $_SESSION['nombre'] = $dato['nomusu'];
                $_SESSION['paterno'] = $dato['apausu'];
                $_SESSION['materno'] = $dato['amausu'];
                $_SESSION['rol'] = $dato['idtipo'];
                header('location: Cliente/inicio.php');
            } else {
                $alert = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                     Usuario y/o contraseña incorrecta!!!
                </div>
            </div>';
                session_destroy();
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tinny VV Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <!--<div class="container" style="background-color: blueviolet;">
        <h1>Bienvenidos</h1>
    </div>--->
    <div class="container" style="padding-top:150px">
        <div class="row" style="background-color: rgb(253,219,170);">
            <div class="col" style="background-color: #cdb4db;  text-align: center;">
                <img src="Cliente/img/logoTiendaInstagram.png" width="400px" height="400px" style="padding-top: 20px;">
            </div>
            <div class="col" style="background-color:#e0bbe4;  text-align: center; font-family: 'Times New Roman', serif;">
                <h1 style="color: #2a1611">Autentificación</h1>

                <form style="padding: 25px;" method="POST">
                    <div>
                        <?php echo isset($alert) ? $alert : ""; ?>
                    </div>
                    <div class="mb-3" style="text-align: left;">
                        <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" aria-describedby="emailHelp" name="correo">
                        <div id="emailHelp" class="form-text">No olvides ingresar todos tus datos.
                        </div>
                    </div>
                    <div class="mb-3" style="text-align: left;">
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contra" name="contra">
                    </div>
                    <div class="form-check form-switch" style="text-align: left;"  >
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Verifica</label>


                    </div>
                    <button type="submit" class="btn btn-outline-dark">Enviar</button>
                </form>

            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>