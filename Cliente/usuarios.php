<?php
session_start();
include "../Servidor/conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['cam1']) || empty($_POST['cam2']) || empty($_POST['cam3']) || empty($_POST['cam4']) || empty($_POST['cam5'])) {
        $alert = '<div class="alert alert-primary" role="alert">
                    Todo los campos son obligatorios
                </div>';
    } else {

        $c1 = $_POST['cam1'];
        $c2 = $_POST['cam2'];
        $c3 = $_POST['cam3'];
        $c4 = $_POST['cam4'];
        $c5 = $_POST['cam5'];
        $c6 = $_POST['cam6'];
        $c7 = $_POST['cam7'];
        $c8 = md5($_POST['cam5']); //contraseña encriptada
        $query = mysqli_query($conexion, "SELECT * FROM usuarios where correo = '$c4'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El correo y/o usuario  ya existe!!!
                    </div>';
        } else {
            $consulta = mysqli_query($conexion, "INSERT INTO 
             usuarios(nomusu,apausu,amausu,correo,contra,telefono,idtipo) 
            values('$c1','$c2','$c3','$c4','$c5','$c6',$c7)");
            if ($consulta) {
                $alert = '<div class="alert alert-danger" role="alert">
                       Datos registrados!!!
                    </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al guardar la información!!!
                    </div>';
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>

    <!--ENCABEZADO-->
    <?php include_once("include/encabezado.php"); ?>
    <!--ENCABEZADO-->
    <div class="container" style="text-align:center; font-family: 'Times New Roman', serif;"">
        <h2>
            Administración de Usuarios
        </h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Nuevo Usuario
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materno</th>

                    <?php if ($_SESSION['rol'] == 1) { ?>
                    <th scope="col">Correo</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Acciones</th>
                    <?php } ?>

                </tr>
            </thead>
            <tbody>
                <?php
                include_once("../Servidor/conexion.php");
                $con = mysqli_query($conexion, "Select u.idusu,u.nomusu, u.apausu, u.amausu, u.correo, u.telefono, t.tipousu From usuarios u INNER JOIN tipousuarios t ON u.idtipo=t.idtipo");
                $res = mysqli_num_rows($con);
                while ($datos = mysqli_fetch_assoc($con)) {
                ?>
                <tr>
                    <td><?php echo $datos['nomusu'] ?></td>
                    <td><?php echo $datos['apausu'] ?></td>
                    <td><?php echo $datos['amausu'] ?></td>

                    <?php if ($_SESSION['rol'] == 1) { ?>
                    <td><?php echo $datos['correo'] ?></td>
                    <td><?php echo $datos['telefono'] ?></td>
                    <td><?php echo $datos['tipousu'] ?></td>
                    <td><a href="editar_usuario.php?id=<?php echo $datos['idusu']; ?>">
                            <button type="button" class="btn btn-dark"> <img src="img/varita-magica.png" height="16px" width="16px">
                            </button>
                        </a>
                    </td>
                    <td><a href="../Servidor/borrar_usuario.php?id=<?php echo $datos['idusu']; ?>"><button type="button"
                                class="btn btn-danger"><img src="img/borrador.png" height="16px" width="16px">
                            </button>
                        </a>
                    </td>
                    <?php } ?>


                </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form style="margin: 5%" method="POST">
                        <div>
                            <?php echo isset($alert) ? $alert : ""; ?>
                        </div>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Nombre</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam1" name="cam1">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Apellido Paterno</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam2" name="cam2">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Apellido Materno</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam3" name="cam3">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Correo</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam4" name="cam4">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Contraseña</span>
                            <input type="password" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam5" name="cam5">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Telefono</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="addon-wrapping" id="cam6" name="cam6">
                        </div>
                        <br>
                        <select class="form-select" aria-label="Default select example" id="cam7" name="cam7">

                            <?php
                            include_once("../Servidor/conexion.php");
                            $cone = mysqli_query($conexion, "Select * From tipousuarios");
                            $resu = mysqli_num_rows($cone);
                            while ($datos = mysqli_fetch_assoc($cone)) {
                            ?>


                            <option value=<?php echo $datos['idtipo'] ?>><?php echo $datos['tipousu'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="Submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--FOOTER-->
    <footer>
        <?php include_once("include/pie.php"); ?>
    </footer>
    <!--FOOTER-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>



</html>