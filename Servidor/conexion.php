<?php
$host="localhost";
$user="root";
$clave="";
$bd="negocio";
$conexion=mysqli_connect($host,$user,$clave,$bd);
if(mysqli_connect_errno()){
    echo "no se pudo  conectar  la bd";
    exit();
}
mysqli_select_db($conexion,$bd)or die("no se  encuentra la  bd");
mysqli_set_charset($conexion,"utf8");
?>