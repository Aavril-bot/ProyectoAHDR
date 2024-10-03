<?php
include "../Servidor/conexion.php";
$alert = "";

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobar si todos los campos están llenos
    if (empty($_POST['cam1']) || empty($_POST['cam2']) || empty($_POST['cam3']) || empty($_POST['cam4']) || empty($_POST['cam5'])) {
        $alert = '<div class="alert alert-primary" role="alert">
                    Todos los campos son obligatorios.
                </div>';
    } else {
        // Sanitizar y asignar valores de los campos
        $c1 = mysqli_real_escape_string($conexion, $_POST['cam1']);
        $c2 = mysqli_real_escape_string($conexion, $_POST['cam2']);
        $c3 = mysqli_real_escape_string($conexion, $_POST['cam3']);
        $c4 = mysqli_real_escape_string($conexion, $_POST['cam4']);
        $c5 = mysqli_real_escape_string($conexion, $_POST['cam5']);
        $c6 = mysqli_real_escape_string($conexion, $_POST['cam6']);
        $c7 = (int)$_POST['cam7'];
        $c8 = md5($c5); // Contraseña encriptada

        // Verificar si el correo ya existe
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->bind_param('s', $c4);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El correo ya existe.
                    </div>';
        } else {
            // Insertar los datos en la base de datos
            $stmt = $conexion->prepare("INSERT INTO usuarios (nomusu, apausu, amausu, correo, contra, telefono, idtipo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssi', $c1, $c2, $c3, $c4, $c8, $c6, $c7);

            if ($stmt->execute()) {
                $alert = '<div class="alert alert-success" role="alert">
                           Datos registrados correctamente.
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al guardar la información.
                        </div>';
            }
        }
        $stmt->close();
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
    <title>Administración de Usuarios</title>
</head>

<body>
    <!--ENCABEZADO-->
    <?php include_once("include/encabezado.php"); ?>
    <!--ENCABEZADO-->
    <div class="container" style="text-align:center">
        <h2>Administración de Usuarios</h2>
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
                $stmt = $conexion->prepare("SELECT u.NomUsu, u.ApaUsu, u.AmaUsu, u.Correo, u.Telefono, t.tipousu FROM usuarios u INNER JOIN tipousuarios t ON u.idtipo = t.idtipo");
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($datos = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($datos['NomUsu']); ?></td>
                    <td><?php echo htmlspecialchars($datos['ApaUsu']); ?></td>
                    <td><?php echo htmlspecialchars($datos['AmaUsu']); ?></td>
                    <?php if ($_SESSION['rol'] == 1) { ?>
                    <td><?php echo htmlspecialchars($datos['Correo']); ?></td>
                    <td><?php echo htmlspecialchars($datos['Telefono']); ?></td>
                    <td><?php echo htmlspecialchars($datos['tipousu']); ?></td>
                    <td><button type="button" class="btn btn-dark"> <img src="Imagenes/lapiz.png" height="16px"
                                width="16px"></button></td>
                    <td><button type="button" class="btn btn-danger"><img src="Imagenes/cruz.png" height="16px"
                                width="16px"></button></td>
                    <?php } ?>
                </tr>
                <?php
                }
                $stmt->close();
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
                            <?php echo $alert; ?>
                        </div>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Nombre</span>
                            <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre"
                                aria-describedby="addon-wrapping" id="cam1" name="cam1">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Apellido Paterno</span>
                            <input type="text" class="form-control" placeholder="Apellido Paterno"
                                aria-label="Apellido Paterno" aria-describedby="addon-wrapping" id="cam2" name="cam2">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Apellido Materno</span>
                            <input type="text" class="form-control" placeholder="Apellido Materno"
                                aria-label="Apellido Materno" aria-describedby="addon-wrapping" id="cam3" name="cam3">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Correo</span>
                            <input type="email" class="form-control" placeholder="Correo" aria-label="Correo"
                                aria-describedby="addon-wrapping" id="cam4" name="cam4">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Contraseña</span>
                            <input type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña"
                                aria-describedby="addon-wrapping" id="cam5" name="cam5">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">Telefono</span>
                            <input type="text" class="form-control" placeholder="Telefono" aria-label="Telefono"
                                aria-describedby="addon-wrapping" id="cam6" name="cam6">
                        </div>
                        <br>
                        <select class="form-select" aria-label="Tipo de Usuario" id="cam7" name="cam7">
                            <?php
                            $stmt = $conexion->prepare("SELECT * FROM tipousuarios");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($datos = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo htmlspecialchars($datos['idtipo']); ?>"><?php