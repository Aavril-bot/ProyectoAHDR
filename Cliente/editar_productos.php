<?php
include_once("../Servidor/conexion.php");

// Actualizar producto
if (!empty($_POST)) {
  $alert = "";

  // Validación de campos vacíos
  if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['cantidad']) || empty($_POST['precio']) || empty($_POST['color']) || empty($_POST['tamanio']) || empty($_POST['foto']) || empty($_POST['idcat'])) {
    $alert = '<div class="alert alert-danger" role="alert">Todos los campos son requeridos</div>';
  } else {
    // Recogiendo datos del formulario
    $idprod = intval($_GET['id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $color = $_POST['color'];
    $tamanio = $_POST['tamanio'];
    $foto = $_POST['foto'];
    $idcat = $_POST['idcat'];

    // Query para actualizar datos del producto
    $sql_update = mysqli_query($conexion, "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad', precio='$precio', color='$color', tamanio='$tamanio', foto='$foto', idcat='$idcat' WHERE idprod=$idprod");

    if ($sql_update) {
      // Redirigir con parámetro de éxito
      header("Location: ../Cliente/productos.php?update=success");
      exit();
    } else {
      $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el producto</div>';
    }
  }
}

// Mostrar datos del producto
if (empty($_REQUEST['id'])) {
  header("Location: ../Cliente/productos.php");
  exit();
}

$idprod = intval($_REQUEST['id']);

$stmt = $conexion->prepare("SELECT * FROM productos WHERE idprod = ?");
$stmt->bind_param("i", $idprod);
$stmt->execute();
$result = $stmt->get_result();
$result_sql = $result->num_rows;

if ($result_sql == 0) {
  header("Location: ../Cliente/productos.php");
  exit();
} else {
  $data = $result->fetch_assoc();
  $nombre = $data['nombre'];
  $descripcion = $data['descripcion'];
  $cantidad = $data['cantidad'];
  $precio = $data['precio'];
  $color = $data['color'];
  $tamanio = $data['tamanio'];
  $foto = $data['foto'];
  $idcat = $data['idcat'];
}
?>
<?php include_once "../Cliente/include/encabezado.php"; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 m-auto">
      <form action="" method="post">
        <?php echo isset($alert) ? $alert : ''; ?>
        <input type="hidden" name="id" value="<?php echo $idprod; ?>">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <input type="text" placeholder="Ingrese descripción" class="form-control" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
        </div>
        <div class="form-group">
          <label for="cantidad">Cantidad</label>
          <input type="text" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>">
        </div>
        <div class="form-group">
          <label for="precio">Precio</label>
          <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio" value="<?php echo $precio; ?>">
        </div>
        <div class="form-group">
          <label for="color">Color</label>
          <input type="text" placeholder="Ingrese color" class="form-control" name="color" id="color" value="<?php echo $color; ?>">
        </div>
        <div class="form-group">
          <label for="tamanio">Tamaño</label>
          <input type="text" placeholder="Ingrese tamaño" class="form-control" name="tamanio" id="tamanio" value="<?php echo $tamanio; ?>">
        </div>
        <div class="form-group">
          <label for="foto">Foto</label>
          <input type="text" placeholder="Ingrese ruta de la foto" class="form-control" name="foto" id="foto" value="<?php echo $foto; ?>">
        </div>
        <div class="form-group">
          <label for="categoria">Categoría</label>
          <select name="idcat" id="categoria" class="form-control">
            <?php
            // Cargar categorías
            $categorias = mysqli_query($conexion, "SELECT * FROM categorias");
            while ($cat = mysqli_fetch_assoc($categorias)) {
              echo "<option value='{$cat['idcat']}' " . ($idcat == $cat['idcat'] ? "selected" : "") . ">{$cat['categoria']}</option>";
            }
            ?>
          </select>
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='../Cliente/productos.php'">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-box-edit"></i> Editar Producto</button>

      </form>
    </div>
  </div>
</div>
<!-- End of Main Content -->
<?php include_once "../Cliente/include/pie.php"; ?>