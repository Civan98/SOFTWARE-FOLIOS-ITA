<?php
$deptoAS  = $_POST['depto_a_Sol'];
$cantidad = $_POST['cantidad'];
$asunto   = $_POST['asunto'];

if ($deptoAS == "" || $cantidad == "" || $asunto == "") {
    header("location: formsolicitar.php");
} else {

    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];
    if (!$conexion) {
        echo "Falla en la conexión";
    } else {
        $bd       = mysqli_select_db($conexion, 'bdgeneradorfolios');
        $q        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion, $q);
        $array    = mysqli_fetch_array($consulta);
        $IDU      = $array['id'];
        $deptoU   = $array['id_depto'];
        if (!$bd) {
            echo "no se encontró la base de datos";
        }
    }

    $buscarDeptoAS = mysqli_query($conexion, "SELECT id_depto FROM departamentos WHERE nombre_departamentos = '$deptoAS'");
    if (!$buscarDeptoAS) {
        echo "error: " . mysqli_error($conexion);
    }
    $depa = "";
    foreach ($buscarDeptoAS as $DaS) {
        $depa = $DaS['id_depto'];
    }
    //buscar el último id_solicitud y comparar el año
    $anioActual = strftime("%Y");
    $ultima_solicitud = mysqli_query ($conexion, "SELECT MAX(id_solicitud) as id_solicitud, year FROM solicitudes WHERE year = '$anioActual'");
    $uS = mysqli_fetch_array($ultima_solicitud);

    if(!$ultima_solicitud){
        $id_sol = 1;        
    } else {
        
        if ($anioActual == $uS['year']) {
            $id_sol = $uS['id_solicitud'];
            $id_sol++;
        }
        else{
            $id_sol = 1;
        }
        

        $year = strftime("%Y");
        $insertar = "INSERT INTO solicitudes ( year, id_depto_sol, id_solicitud, id_depto_genera, cantidad, asunto, estado, id_usuario, fecha) VALUES ('$year','$deptoU', '$id_sol', " . $depa . ",'$cantidad','$asunto','Solicitado', '$IDU', NOW())";
        $exec     = mysqli_query($conexion, $insertar);

        if (!$exec) {
            echo "error ".mysqli_error($conexion);
        } else {

            echo "<script language='javascript'> alert('Solicitud realizada con éxito');  window.location.href='formsolicitar.php';</script>";
        }
    }
    mysqli_close($conexion);
}
