<?php
include_once("conexion.php");
if(!empty($_GET['id'])){
    $clave=$_GET['id'];
    $consulta=mysqli_query($conexion,"DELETE FROM categorias WHERE idcat=$clave");
    mysqli_close($conexion);
    header("Location:../Cliente/categorias.php");
}
?>