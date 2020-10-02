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


            $fechaActual = "" . date("d") . "/" . date("m") . "/" . date("Y");
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
            $this->Cell(110, 10, 'REPORTE DE SOLICITUDUD DE FOLIOS ', 1, 1, 'C');
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
            $this->Cell(30, 10, 'NO. SOLICITUD', 1, 0, 'C', true);
            $this->Cell(40, 10, 'FECHA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'DPTO. QUE SOLICITA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'DPTO. AL QUE SOLICITA', 1, 0, 'C', true);
            $this->Cell(50, 10, 'ASUNTO', 1, 0, 'C', true);
            $this->Cell(20, 10, 'FOLIO', 1, 0, 'C', true);
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
    $id_sol = $_POST['id']; //id de la solicitud

    $q        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
    $consulta = mysqli_query($conexion, $q);
    $array    = mysqli_fetch_array($consulta);
    $ID       = $array['id'];

    //consulta para obtener los folios de la solicitud
    $q2        = "SELECT * from folios where id_solicitud = '$id_sol' ";
    $consulta2 = mysqli_query($conexion, $q2);//consulta para la obtencion del id del depto
    $consultar = mysqli_query($conexion, $q2);//consulta para el ciclo while
    $array2    = mysqli_fetch_array($consulta2);

    // consulta para obtener el nombre del depa del usuario
    $q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
    $consulta3 = mysqli_query($conexion, $q3);
    $array3    = mysqli_fetch_array($consulta3);

    //consulta para obtener el nombre del depa que genera
    $id_genera      = $array2['id_depto_genera'];//id del que genera
    $q4        = "SELECT * from departamentos where id_depto = '$id_genera' ";
    $consulta4 = mysqli_query($conexion, $q4);
    $array4    = mysqli_fetch_array($consulta4);
    $nombre_genera  = $array4['nombre_departamentos'];

    //$pdf = new PDF();
    $pdf=new PDF('L','mm','A4');//lianea para PDF horizontal
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 9);

    //$pdf->Cell(40,10,$usuario);
    while ($row = mysqli_fetch_array($consultar)) {
        $pdf->Cell(5);//alineador

       // $nombre_solA;
        switch($array3['nombre_departamentos']){
            case 'Dirección':
                $nombre_solA = "Dirección";
                break;
                case 'Subdirección de Planeación y Vinculación':
                    $nombre_solA = "Subd. De planeacion y vin.";
                    break;
                    case 'Departamento de Comunicación y Difusión':
                        $nombre_solA = "Dpto. De C.y Difusión";
                        break;
                        case 'Planeación, Programación y Presupuestación':
                            $nombre_solA = "Plan. Progr. y Pres.";
                            break;
                            case 'Departamento de Servicios Escolares':
                                $nombre_solA = "Dpto. De S. E.";
                                break;
                                case 'Departamento de Gestión Tecnológica y Vinculación':
                                    $nombre_solA = "Dpto. G.T.V.";
                                    break;
                                    case 'Centro de Información':
                                        $nombre_solA = "Centro De Infor.";
                                        break;
                                        case 'Departamento de Actividades Extraescolares':
                                            $nombre_solA = "Dpto. De Act. Extra.";
                                            break;
                                            case 'Subdirección Académica':
                                                $nombre_solA = "Sub. Académica";
                                                break;
                                                case 'Departamento de Desarrollo Académico':
                                                    $nombre_solA = "Dpto. De Des. Acad.";
                                                    break;
                                                    case 'Departamento de Ciencias Básicas':
                                                        $nombre_solA = "Dpto. Cien. Bás.";
                                                        break;
                                                        case 'Departamento de Bioquímica':
                                                            $nombre_solA = "Dpto. De Bio.";
                                                            break;
                                                            case 'Departamento de Arquitectura':
                                                                $nombre_solA = "Dpto. De Arq.";
                                                                break;
                                                                case 'Departamento de Sistemas y Computación':
                                                                    $nombre_solA = "Dpto. De Sis. Y Com.";
                                                                    break;
                                                                    case 'Departamento de Ciencias Económico-Administrativas':
                                                                        $nombre_solA = "Dpto. De Cien. E. Adm.";
                                                                        break;
                                                                        case 'Departamento de Metalmecánica':
                                                                            $nombre_solA = "Dpto. De Metal.";
                                                                            break;
                                                                            case 'División de Posgrado e Investigación':
                                                                                $nombre_solA = "Div. De Posg. E inv.";
                                                                                break;
                                                                                case 'División de Estudios Profesionales':
                                                                                    $nombre_solA = "Div. De Est. Pro.";
                                                                                    break;
                                                                                    case 'Departamento de Gestión Empresarial':
                                                                                        $nombre_solA = "Dpto. De G.E.";
                                                                                        break;
                                                                                        case 'Subdirección de Servicios Administrativos':
                                                                                            $nombre_solA = "Sub. De Serv. Adm.";
                                                                                            break;
                                                                                            case 'Departamento de Recursos Financieros':
                                                                                                $nombre_solA = "Dpto. De Rec. Fin.";
                                                                                                break;
                                                                                                case 'Departamento de Recursos Humanos':
                                                                                                    $nombre_solA = "Dpto. De R. H.";
                                                                                                    break;
                                                                                                    case 'Departamento de Recursos Materiales y Servicios':
                                                                                                        $nombre_solA = "Dpto. De Rec. M. y Ser.";
                                                                                                        break;
                                                                                                        case 'Centro de Cómputo':
                                                                                                            $nombre_solA = "Centro de Cómputo";
                                                                                                            break;
                                                                                                            case 'Departamento de Mantenimiento de Equipo':
                                                                                                                $nombre_solA = "Dpto. de M. de E.";
                                                                                                                break;





            }

            $nombre_genA = "";
            switch($nombre_genera){
                case 'Dirección':
                    $nombre_genA = "Dirección";
                    break;
                    case 'Subdirección de Planeación y Vinculación':
                        $nombre_genA = "Subd. De planeacion y vin.";
                        break;
                        case 'Departamento de Comunicación y Difusión':
                            $nombre_genA = "Dpto. De C.y Difusión";
                            break;
                            case 'Planeación, Programación y Presupuestación':
                                $nombre_genA = "Plan. Progr. y Pres.";
                                break;
                                case 'Departamento de Servicios Escolares':
                                    $nombre_genA = "Dpto. De S. E.";
                                    break;
                                    case 'Departamento de Gestión Tecnológica y Vinculación':
                                        $nombre_genA = "Dpto. G.T.V.";
                                        break;
                                        case 'Centro de Información':
                                            $nombre_genA = "Centro De Infor.";
                                            break;
                                            case 'Departamento de Actividades Extraescolares':
                                                $nombre_genA= "Dpto. De Act. Extra.";
                                                break;
                                                case 'Subdirección Académica':
                                                    $nombre_genA = "Sub. Académica";
                                                    break;
                                                    case 'Departamento de Desarrollo Académico':
                                                        $nombre_genA = "Dpto. De Des. Acad.";
                                                        break;
                                                        case 'Departamento de Ciencias Básicas':
                                                            $nombre_genA= "Dpto. Cien. Bás.";
                                                            break;
                                                            case 'Departamento de Bioquímica':
                                                                $nombre_genA= "Dpto. De Bio.";
                                                                break;
                                                                case 'Departamento de Arquitectura':
                                                                    $nombre_genA= "Dpto. De Arq.";
                                                                    break;
                                                                    case 'Departamento de Sistemas y Computación':
                                                                        $nombre_genA= "Dpto. De Sis. Y Com.";
                                                                        break;
                                                                        case 'Departamento de Ciencias Económico-Administrativas':
                                                                            $nombre_genA= "Dpto. De Cien. E. Adm.";
                                                                            break;
                                                                            case 'Departamento de Metalmecánica':
                                                                                $nombre_genA = "Dpto. De Metal.";
                                                                                break;
                                                                                case 'División de Posgrado e Investigación':
                                                                                    $nombre_genA = "Div. De Posg. E inv.";
                                                                                    break;
                                                                                    case 'División de Estudios Profesionales':
                                                                                        $nombre_genA = "Div. De Est. Pro.";
                                                                                        break;
                                                                                        case 'Departamento de Gestión Empresarial':
                                                                                            $nombre_genA = "Dpto. De G.E.";
                                                                                            break;
                                                                                            case 'Subdirección de Servicios Administrativos':
                                                                                                $nombre_genA = "Sub. De Serv. Adm.";
                                                                                                break;
                                                                                                case 'Departamento de Recursos Financieros':
                                                                                                    $nombre_genA = "Dpto. De Rec. Fin.";
                                                                                                    break;
                                                                                                    case 'Departamento de Recursos Humanos':
                                                                                                        $nombre_genA = "Dpto. De R. H.";
                                                                                                        break;
                                                                                                        case 'Departamento de Recursos Materiales y Servicios':
                                                                                                            $nombre_genA = "Dpto. De Rec. M. y Ser.";
                                                                                                            break;
                                                                                                            case 'Centro de Cómputo':
                                                                                                                $nombre_genA = "Centro de Cómputo";
                                                                                                                break;
                                                                                                                case 'Departamento de Mantenimiento de Equipo':
                                                                                                                    $nombre_genA = "Dpto. de M. de E.";
                                                                                                                    break;
    
    
    
    
    
                }

        $pdf->Cell(30,10, $row['id_solicitud'], 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $row['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode($nombre_solA), 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode($nombre_genA), 1, 0, 'C', 0);
        $pdf->Cell(50, 10, utf8_decode($row['asunto']), 1, 0, 'L', 0);
        $pdf->Cell(20, 10, $row['id_folio'], 1, 0, 'C', 0);
        $pdf->Cell(30, 10, $row['estado'], 1, 1, 'C', 0);
    }

    $pdf->Output();
}
