<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiny VV Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="js/pie.css" rel="stylesheet">
</head>

<body>
    <header>
        <!--encabezado-->
        <?php include_once("include/encabezado.php") ?>
        <!--fin encabezado-->
    </header>
    <div class="container" style="text-align: center; font-family: 'Times New Roman', serif;">
        <h2>REPORTES DE PRODUCTOS</h2>
        <div class="row">
            <div class="col">
                <a href="R_p_pdf.php">
                    <img src="../Cliente/img/pdf.png" width="150px" height="150px">
                </a>
            </div>
            <div class="col">
                <a href="R_p_excel.php">
                    <img src="../Cliente/img/excel.png" width="150px" height="150px">
                </a>
            </div>
            <div class="col">
                <a href="R_p_grafica.php">
                    <img src="../Cliente/img/barra-grafica.png" width=" 150px" height="150px">
                </a>
            </div>
        </div>


    </div>
    <footer>
        <!-- inicia pie-->
        <?php include_once("include/pie.php") ?>
        <!--fin pie-->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>