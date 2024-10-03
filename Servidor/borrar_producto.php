<?php
include_once("conexion.php");

if (!empty($_GET['id'])) {
    $clave = intval($_GET['id']); // Asegúrate de que el ID sea un entero

    // Ejecutar la consulta de eliminación
    $consulta = mysqli_query($conexion, "DELETE FROM productos WHERE idprod = $clave");

    if ($consulta) {
        // Redirigir a la lista de productos con un mensaje de éxito
        header("Location: ../Cliente/productos.php?delete=success");
    } else {
        // Redirigir a la lista de productos con un mensaje de error
        header("Location: ../Cliente/productos.php?delete=error");
    }
    
    mysqli_close($conexion);
    exit(); // Asegúrate de salir después de la redirección
}
?>
