<?php
// Incluir la librería de FPDF
require("lib/fpdf/fpdf.php");

class PDF extends FPDF {
    //Cabecera
    function Header() {
        $this->Image("img/logoTiendaInstagram.png",10,8,33);
        $this->SetFont("Arial", 'B', 15);
        $this->SetTextColor(85,85,171,67);
        $this->Cell(110);
        $this->Cell(60, 10, 'REPORTE DE USUARIOS EXISTENTES', 0, 0, 'C');
        $this->Ln(30);
        $this->SetFillColor(206,202,242,95);
        $this->SetTextColor(85,85,171,67);
        $this->SetFont("Arial", 'B', 12);
        $this->Cell(30, 10, utf8_decode('Nombre'), 0, 0, 'C', true);
        $this->Cell(40, 10, utf8_decode('Paterno'), 0, 0, 'C', true);
        $this->Cell(40, 10, utf8_decode('Materno'), 0, 0, 'C',true);
        $this->Cell(100, 10,utf8_decode('Correo Electrónico') , 0, 0, 'C',true);
        $this->Cell(50, 10, utf8_decode('Número Telefónico'), 0, 0, 'C',true);
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        // Posición a 1.5 cm del final de la página
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

// Incluir la conexión a la base de datos
require("../Servidor/conexion.php");

// Asegurarse de que la conexión se estableció correctamente
if (mysqli_connect_errno()) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Consulta a la base de datos
$consulta = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Fetch data and display it in the PDF
while ($row = mysqli_fetch_assoc($resultado)) {
    $pdf->Cell(30, 10,utf8_decode( $row['NomUsu']), 0, 0, 'C',);
    $pdf->Cell(40, 10,utf8_decode( $row['ApaUsu']), 0, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row['AmaUsu']), 0, 0, 'C');
    $pdf->Cell(100, 10, $row['Correo'], 0, 0, 'C');
    $pdf->Cell(50, 10, $row['Telefono'],0, 0, 'C');
    $pdf->Ln();
}
$pdf->Output();
?>