<?php 
if (!isset($_SESSION['tiempo'])) {
    $_SESSION['tiempo'] = time();
} else if (time() - $_SESSION['tiempo'] > 1000) {
    session_destroy();
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Sesión Expirada',
            text: 'Tu sesión ha expirado.',
            confirmButtonText: 'Ok',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../';
            }
        });
    </script>
    ";
    die();  
}
$_SESSION['tiempo'] = time();
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid" style="text-align: center; padding-top:40px; background-color:#e0bbe4; font-family: 'Times New Roman', serif;">
        <div class="row">
            <div class="col-3">
                <img src="img/logoTiendaInstagram.png" width="250px" height="250px" style="padding-top: 5px;">
            </div>
            <div class="col">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="inicio.php"><button type="button" class="btn btn-light">Inicio</button></a>
                    <a href="usuarios.php"><button type="button" class="btn btn-light">Usuarios</button></a>
                    <a href="categorias.php"><button type="button" class="btn btn-light">Categorias</button></a>
                    <a href="productos.php"><button type="button" class="btn btn-light">Productos</button></a>
                    <a href="promociones.php"><button type="button" class="btn btn-light">Promociones</button></a>
                    <a href="reportes.php"><button type="button" class="btn btn-light">Reportes Usuario</button></a>
                    <a href="reportes_c.php"><button type="button" class="btn btn-light">Reportes Categorias</button></a>
                    <a href="reportes_p.php"><button type="button" class="btn btn-light">Reportes Productos</button></a>
                    <a href="salir.php"><button type="button" class="btn btn-dark">Salir</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>