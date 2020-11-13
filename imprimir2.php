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
            require 'logica/conexion.php';
            $usuario = $_SESSION['username'];
            $q5        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
            $consulta5 = mysqli_query($conexion, $q5);
            $array5    = mysqli_fetch_array($consulta5);
            $nombre       = $array5['nombre'];
            $ape       = $array5['apellidos'];


            $fechaActual = "" . date("d") ."/" . date("m") . "/" . date("Y");
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
            $this->Cell(110, 10, 'REPORTE DE FOLIOS ', 1, 1, 'C');
            // Arial bold 10
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(75, 30, utf8_decode("Fecha de impresión: " . $fechaActual), 0, 0, 'C');
            $this->Cell(75, 30, utf8_decode("Solicitante: " .$nombre.' '.$ape), 0, 0, 'C');
            // Salto de línea
            $this->Ln(25);
            $this->SetFont('Arial', 'B', 11);
            //alineador de la tabla
            $this->Cell(5);
            //cabecera de la tabla
            $this->SetFillColor(180, 180, 180);
            $this->Cell(50, 10, 'FOLIO', 1, 0, 'C', true);
            $this->Cell(50, 10, 'FECHA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'DPTO. QUE SOLICITA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'DPTO. AL QUE SOLICITA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'ASUNTO', 1, 0, 'C', true);
           // $this->Cell(25, 10, 'SOLICITANTE', 1, 0, 'C', true);
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
   
    //consulta para el ID del depa del usuario
    $q5        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
    $consulta5 = mysqli_query($conexion, $q5);
    $array5    = mysqli_fetch_array($consulta5);
    $id_deptoU       = $array5['id_depto'];
    
    if($usuario =="admin"){
        $q  = "SELECT * FROM folios ORDER BY id_depto_genera ASC, id_folio DESC";
    }else{
        $q  = "SELECT * FROM folios WHERE id_depto_sol = '$id_deptoU' ORDER BY id_depto_genera ASC, id_folio DESC";
    }
   
   
    $consulta = mysqli_query($conexion, $q);
   // $array1    = mysqli_fetch_array($consulta);
   // $id_depto_g       = $array1['id_depto_genera'];

    //$pdf = new PDF();
       

    $pdf=new PDF('L','mm','A4');//lianea para PDF horizontal
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 9);

    //consulta para el depto que solicita
    $q4        = "SELECT * from departamentos where id_depto = '$id_deptoU' ";
    $consulta4 = mysqli_query($conexion, $q4);
    $array4    = mysqli_fetch_array($consulta4);
    //$nombre_sol  = $array4['nom_corto'];

  
    while ($row = mysqli_fetch_array($consulta)) {
        $pdf->Cell(5);//alineador
        //consulta para el depto que genera
        $id_dg = $row['id_depto_genera'];
        $nombre_s = $row['id_depto_sol'];

        $q6   = "SELECT * from departamentos where id_depto = '$id_dg' ";
        $q7   = "SELECT * from departamentos where id_depto = '$nombre_s' ";

        $consulta6 = mysqli_query($conexion, $q6);
        $consulta7 = mysqli_query($conexion, $q7);

        $array6    = mysqli_fetch_array($consulta6);
        $array7    = mysqli_fetch_array($consulta7);

        $nombre_gen  = $array6['nom_corto'];
        $nombre_sol  = $array7['nom_corto'];
          

        $x_axis=$pdf->getx(); 
        $c_width=50;// cell width 
        $c_height=10;
        $pdf->vcell($c_width,$c_height,$x_axis,$row['id_folio']);
        $x_axis=$pdf->getx(); 
        $pdf->vcell($c_width,$c_height,$x_axis,$row['fecha']);
        $x_axis=$pdf->getx(); 
        $pdf->vcell($c_width,$c_height,$x_axis,utf8_decode($nombre_sol));
        $x_axis=$pdf->getx(); 
        $pdf->vcell($c_width,$c_height,$x_axis,utf8_decode($nombre_gen));
        $x_axis=$pdf->getx(); 
        $pdf->vcell($c_width,$c_height,$x_axis,utf8_decode($row['asunto']));
        $x_axis=$pdf->getx(); 
        $pdf->vcell(30,$c_height,$x_axis,$row['estado']);
        $pdf->Ln();

        // $pdf->Cell(20, 10, $row['id_folio'], 1, 0, 'C', 0);
        // $pdf->Cell(40, 10, $row['fecha'], 1, 0, 'C', 0);
        // $pdf->Cell(50, 10, utf8_decode($nombre_sol), 1, 0, 'C', 0);
        // $pdf->Cell(50, 10, utf8_decode($nombre_gen), 1, 0, 'C', 0);
        // $pdf->Cell(50, 10, utf8_decode($row['asunto']), 1, 0, 'L', 0);
        // $pdf->Cell(30, 10, $row['estado'], 1, 1, 'C', 0);
    }

    $pdf->Output();
}