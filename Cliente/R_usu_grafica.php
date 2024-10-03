<?php
session_start();
include_once("../Servidor/conexion.php");

// Verifica que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para contar usuarios por tipo de usuario y obtener el nombre del tipo de usuario
$sql = "SELECT t.tipousu, COUNT(u.idtipo) AS total
        FROM usuarios AS u
        INNER JOIN tipousuarios AS t ON u.idtipo = t.idtipo
        GROUP BY t.idtipo"; // Agrupa por idtipo para obtener conteos por tipo de usuario

$res = $conexion->query($sql);

if (!$res) {
    die("Error en la consulta SQL: " . $conexion->error);
}
?>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tipo de Usuario', 'Cantidad de Usuarios'],
            <?php
                $rows = [];
                while ($fila = $res->fetch_assoc()) {
                    // Escapar valores de PHP para evitar problemas con comillas en JavaScript
                    $tipousu = htmlspecialchars($fila["tipousu"], ENT_QUOTES);
                    $rows[] = "['" . $tipousu . "'," . $fila["total"] . "]";
                }
                echo implode(",", $rows);
            ?>
        ]);

        var options = {
            title: 'CANTIDAD DE USUARIOS POR TIPO',
            width: 600,
            height: 400,
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    </script>
</head>

<body>
    <header>
        <!-- Encabezado -->
        <?php include_once("include/encabezado.php") ?>
        <!-- Fin encabezado -->
    </header>

    <div id="chart_div"></div>

    <footer>
        <?php include_once("include/pie.php"); ?>
    </footer>

</body>

</html>
