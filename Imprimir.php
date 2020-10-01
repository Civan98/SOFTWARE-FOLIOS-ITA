<?php
require 'fpdf/fpdf.php';
require 'logica/conexion.php';

session_start();
$usuario = $_SESSION['username'];
date_default_timezone_set("America/Mexico_City");

if (!isset($usuario)) {
    header("location: index.php");
} else {

    class PDF extends FPDF
    {
        // Cabecera de página
        public function Header()
        {
            $fechaActual = "" . date("d") . " del " . date("m") . " de " . date("Y");
            // Logo (dirección de la imagen,Y,X,zoom)
            $this->Image('imagenes/header.png', 50, 5, 200);
            //marca de awa
            $this->Image('imagenes/printlogo.jpg', 0, 40, 150);
            // Salto de línea
            $this->Ln(29);
            // Movernos a la derecha
            $this->Cell(85);
            // Título
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(110, 10, 'REPORTE DE SOLICITUDES DE FOLIOS ', 1, 1, 'C');
            // Arial bold 10
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(75, 30, utf8_decode("Fecha de impresión: " . $fechaActual), 0, 0, 'C');
            // Salto de línea
            $this->Ln(25);
            $this->SetFont('Arial', 'B', 11);
            //alineador de la tabla
            $this->Cell(5);
            //cabecera de la tabla
            $this->SetFillColor(180, 180, 180);
            $this->Cell(50, 10, 'DPTO. QUE LO GENERA', 1, 0, 'C', true);
            $this->Cell(20, 10, 'FOLIO', 1, 0, 'C', true);
            // $this->Cell(45,10, 'DPTO. que lo solicita', 1, 0, 'C', 0);
            $this->Cell(25, 10, 'USUARIO', 1, 0, 'C', true);
            // $pdf->Cell(10,10, $row['id_solicitud'], 1, 0, 'C', 0);
            $this->Cell(40, 10, 'FECHA', 1, 0, 'C', true);
            $this->Cell(30, 10, 'ASUNTO', 1, 0, 'C', true);
            $this->Cell(30, 10, 'ESTADO', 1, 1, 'C', true);
        }

        // Pie de página
        public function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo()) . '/{nb}', 0, 0, 'C');
        }
        //****************************  CHEQUEN USEN LA SIGUIENTE CONSULTA PARA QUE SE ORDENE COMO QUIERE EL PROFE EL RESULTADO OMITIENDO LO DE LAS FECHAS, PORQUE QUIERE TODA LA TABLA   *****************************
        //$consultaSF = "SELECT * FROM folios WHERE id_depto_sol = '$id_deptoU' and  DATE(fecha) >= '$fecha_inicio' and DATE(fecha) <= '$fecha_final' ORDER BY id_depto_genera ASC, id_folio DESC";
    }
    $id_sol = $_POST['id']; //id de la solicitud

    $q        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
    $consulta = mysqli_query($conexion, $q);
    $array    = mysqli_fetch_array($consulta);
    $ID       = $array['id'];

    //consulta para obtener los folios de la solicitud
    $q2        = "SELECT * from folios where id_solicitud = '$id_sol' ";
    $consulta2 = mysqli_query($conexion, $q2);

    // consulta para obtener el nombre del depa del usuario
    //======ESTA MAL ESTA CONSULTA SOLO MOSTRARA EN LA TABLA EL DEPARTAMENTO DEL USUARIO LOGEADO NO EL DEPARTAMENTO QUE GENERA LO SOLICITUD
    $q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
    $consulta3 = mysqli_query($conexion, $q3);
    $array3    = mysqli_fetch_array($consulta3);

    //$pdf = new PDF();
    $pdf=new PDF('L','mm','A4');//lianea para PDF horizontal
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 9);

    //$pdf->Cell(40,10,$usuario);
    while ($row = mysqli_fetch_array($consulta2)) {
        $pdf->Cell(5);
        $pdf->Cell(50, 10, utf8_decode($array3['nombre_departamentos']), 1, 0, 'C', 0);
        $pdf->Cell(20, 10, $row['id_folio'], 1, 0, 'C', 0);
        // $pdf->Cell(45,10, $row['id_depto_sol'], 1, 0, 'C', 0);
        $pdf->Cell(25, 10, $row['id_usuario'], 1, 0, 'C', 0);
        //$pdf->Cell(10,10, $row['id_solicitud'], 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $row['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($row['asunto']), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, $row['estado'], 1, 1, 'C', 0);
    }

    $pdf->Output();
}
