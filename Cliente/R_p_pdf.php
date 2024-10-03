<?php
// Incluir la librería de fpdf
require("lib/fpdf/fpdf.php");

class PDF extends fpdf {
    // Cabecera de la página
    function Header() {
        // Logotipo
        $this->Image("img/logoTiendaInstagram.png", 18, 8, 33);
        // Tipo de letra
        $this->SetFont("Arial", "B", 15);
        // Movemos a la derecha
        $this->Cell(110);
        // Título
        $this->Cell(60, 10, "REPORTE DE PRODUCTOS", 0, 0, 'C');
        // Salto de línea
        $this->Ln(30);
        $this->SetFillColor(190, 215, 254); // Color a la celda
        $this->SetTextColor(0, 48, 121);
        // Tipo de letra
        $this->SetFont("Arial", "B", 12);
        // Encabezado de la tabla según la imagen proporcionada
        $this->Cell(40, 10, 'Nombre', 0, 0, 'C', true);
        $this->Cell(60, 10, utf8_decode('Descripción'), 0, 0, 'C', true);
        $this->Cell(20, 10, 'Cantidad', 0, 0, 'C', true);
        $this->Cell(30, 10, 'Precio', 0, 0, 'C', true);
        $this->Cell(30, 10, 'Color', 0, 0, 'C', true);
        $this->Cell(30, 10, utf8_decode('Tamaño'), 0, 0, 'C', true);
        $this->Cell(30, 10, 'Foto', 0, 0, 'C', true); // La imagen va al final
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo(), 0, 0, 'C');
    }
}

// Consulta a la base de datos
require("../Servidor/conexion.php");

$consulta = "SELECT * FROM productos"; // Suponiendo que 'productos' es la tabla correspondiente
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die('Error en la consulta:' . mysqli_error($conexion));
}

// Crear nuevo documento PDF
$pdf = new PDF('L');
// Referencia a la clase
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

while ($row = mysqli_fetch_assoc($resultado)) {
    // Mostrar los campos en el orden de la tabla
    $pdf->Cell(40, 30, utf8_decode($row['nombre']), 0, 0, 'C'); // Campo nombre del producto
    $pdf->Cell(60, 30, utf8_decode($row['descripcion']), 0, 0, 'C'); // Campo descripción
    $pdf->Cell(20, 30, $row['cantidad'], 0, 0, 'C'); // Campo cantidad
    $pdf->Cell(30, 30, $row['precio'], 0, 0, 'C'); // Campo precio
    $pdf->Cell(30, 30, utf8_decode($row['color']), 0, 0, 'C'); // Campo color
    $pdf->Cell(30, 30, utf8_decode($row['tamanio']), 0, 0, 'C'); // Campo tamaño

    // Validar si la imagen existe en la carpeta
    if (!empty($row['foto']) && file_exists($row['foto'])) {
        $pdf->Cell(30, 30, $pdf->Image($row['foto'], $pdf->GetX(), $pdf->GetY(), 30, 30), 0, 0, 'C'); // Añadir la imagen
    } else {
        $pdf->Cell(30, 30, 'Sin imagen', 0, 0, 'C'); // Si no existe imagen, mostrar "Sin imagen"
    }

    $pdf->Ln();
}

$pdf->Output(); // Permite la salida de datos
?>