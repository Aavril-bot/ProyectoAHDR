<?php
session_start();
include_once("../Servidor/conexion.php");

// Verifica que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para contar categorías por producto y obtener el nombre del producto
$sql = "SELECT p.nombre, COUNT(c.idcat) AS total
        FROM categorias AS c
        INNER JOIN productos AS p ON c.idcat = p.idcat
        GROUP BY p.idprod"; // Agrupa por idprod para obtener conteos por producto

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
            ['Producto', 'Cantidad de categorías'],
            <?php
                $rows = [];
                while ($fila = $res->fetch_assoc()) {
                    // Escapar valores de PHP para evitar problemas con comillas en JavaScript
                    $producto = htmlspecialchars($fila["nombre"], ENT_QUOTES);
                    $rows[] = "['" . $producto . "'," . $fila["total"] . "]";
                }
                echo implode(",", $rows);
            ?>
        ]);

        var options = {
            title: 'CANTIDAD DE CATEGORÍAS POR PRODUCTO',
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
