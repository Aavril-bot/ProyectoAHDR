<?php
session_start();
include_once("../Servidor/conexion.php");

// Verifica que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para contar productos por categoría y obtener el nombre de la categoría
$sql = "SELECT c.categoria, COUNT(p.idcat) AS total
        FROM productos AS p
        INNER JOIN categorias AS c ON p.idcat = c.idcat
        GROUP BY c.idcat"; // Agrupa por idcat para obtener conteos por categoría

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
            ['Categoría', 'Cantidad de productos'],
            <?php
                $rows = [];
                while ($fila = $res->fetch_assoc()) {
                    // Escapar valores de PHP para evitar problemas con comillas en JavaScript
                    $categoria = htmlspecialchars($fila["categoria"], ENT_QUOTES);
                    $rows[] = "['" . $categoria . "'," . $fila["total"] . "]";
                }
                echo implode(",", $rows);
            ?>
        ]);

        var options = {
            title: 'CANTIDAD DE PRODUCTOS POR CATEGORÍA',
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