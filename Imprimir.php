<?php
    require('fpdf/fpdf.php');
    require 'logica/conexion.php';

    session_start();
    $usuario = $_SESSION['username'];

    if (!isset($usuario)) {
        header("location: index.php");
    } else {

            class PDF extends FPDF
        {
        // Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('imagenes/header.png',30,10,160);
            //marca de awa
            $this->Image('imagenes/fondo.jpg',10,40,460);
            // Salto de línea
            $this->Ln(29);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(40);
            // Título
            $this->Cell(110,10,'REPORTE DE SOLICITUDES DE FOLIOS ',1,0,'C');
            // Salto de línea
            $this->Ln(25);
            $this->SetFont('Arial','B',11);
            //alineador de la tabla
            $this->Cell(10);
            //cabecera de la tabla
            $this->Cell(45,10, 'DPTO. que lo genera', 1, 0, 'C', 0);
            $this->Cell(20,10, 'FOLIO', 1, 0, 'C', 0);
           // $this->Cell(45,10, 'DPTO. que lo solicita', 1, 0, 'C', 0);
            $this->Cell(25,10, 'USUARIO', 1, 0, 'C', 0);
           // $pdf->Cell(10,10, $row['id_solicitud'], 1, 0, 'C', 0);
            $this->Cell(30,10, 'FECHA', 1, 0, 'C', 0);
            $this->Cell(30,10, 'ASUNTO', 1, 0, 'C', 0);
            $this->Cell(30,10, 'ESTADO', 1, 1, 'C', 0);
        }

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()).'/{nb}',0,0,'C');
        }
        }

        $id_sol = $_POST['id'];//id de la solicitud

        $q         = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta  = mysqli_query($conexion, $q);
        $array     = mysqli_fetch_array($consulta);
        $ID        = $array['id'];

        //consulta para obtener los folios de la solicitud
        $q2 = "SELECT * from folios where id_solicitud = '$id_sol' ";
        $consulta2  = mysqli_query($conexion, $q2);
       
        
    
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',11);
        
        //$pdf->Cell(40,10,$usuario);
        while ($row = mysqli_fetch_array($consulta2)) {
            $pdf->Cell(10);
            $pdf->Cell(45,10, $row['id_depto_genera'], 1, 0, 'C', 0);
            $pdf->Cell(20,10, $row['id_folio'], 1, 0, 'C', 0);
           // $pdf->Cell(45,10, $row['id_depto_sol'], 1, 0, 'C', 0);
            $pdf->Cell(25,10, $row['id_usuario'], 1, 0, 'C', 0);
            //$pdf->Cell(10,10, $row['id_solicitud'], 1, 0, 'C', 0);
            $pdf->Cell(30,10, $row['fecha'], 1, 0, 'C', 0);
            $pdf->Cell(30,10, $row['asunto'], 1, 0, 'C', 0);
            $pdf->Cell(30,10, $row['estado'], 1, 1, 'C', 0);
        }


        $pdf->Output();
    }
?>