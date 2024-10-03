<?php
include_once("../Servidor/conexion.php");

// Actualizar categoría
if (!empty($_POST)) {
    $alert = "";
  
    // Validación de campos vacíos
    if (empty($_POST['categoria'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son requeridos</div>';
    } else {
        // Recogiendo datos del formulario
       
        $nombre = mysqli_real_escape_string($conexion, $_POST['categoria']);
  
        // Query para actualizar datos de la categoría
        $sql_update = mysqli_query($conexion, "UPDATE categorias SET categoria='$nombre' WHERE idcat='$idcat'");
        
        if ($sql_update) {
            // Redirigir con parámetro de éxito
            header("Location: ../Cliente/categorias.php?update=success");
            exit();
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la categoría</div>';
        }
    }
}

// Mostrar datos de la categoría
if (empty($_REQUEST['id'])) {
    header("Location: ../Cliente/categorias.php");
    exit();
}

$idcat = intval($_REQUEST['id']);
$stmt = $conexion->prepare("SELECT * FROM categorias WHERE idcat = ?");
$stmt->bind_param("i", $idcat);
$stmt->execute();
$result = $stmt->get_result();
$result_sql = $result->num_rows;

if ($result_sql == 0) {
    header("Location: ../Cliente/categorias.php");
    exit();
} else {
    $data = $result->fetch_assoc();
    $nombre = $data['categoria'];
}
?>
<?php include_once "../Cliente/include/encabezado.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idcat; ?>">
                <div class="form-group">
                    <label for="categoria">Nombre</label>
                    <input type="text" placeholder="Ingrese nombre" class="form-control" name="categoria" id="categoria" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                
                <button type="button" class="btn btn-secondary" onclick="window.location.href='categorias.php'">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Categoría</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include_once "../Cliente/include/pie.php"; ?>
