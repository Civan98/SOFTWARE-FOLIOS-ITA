<?php
$deptoAS  = $_POST['depto_a_Sol'];
$cantidad = $_POST['cantidad'];
$asunto   = $_POST['asunto'];

if ($deptoAS == "" || $cantidad == "" || $asunto == "") {
    header("location: formsolicitar.php");
} else {

    require 'logica/conexion.php';
    session_start();
    date_default_timezone_set("America/Mexico_City");
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
        $autoAutorizar = $array['autoAutorizar'];
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
    $anioActual       = strftime("%Y");
    $ultima_solicitud = mysqli_query($conexion, "SELECT MAX(id_solicitud) as id_solicitud, year FROM solicitudes WHERE year = '$anioActual'");
    $uS               = mysqli_fetch_array($ultima_solicitud);

    if (!$ultima_solicitud) {
        $id_sol = 1;
    } else {

        if ($anioActual == $uS['year']) {
            $id_sol = $uS['id_solicitud'];
            $id_sol++;
        } else {
            $id_sol = 1;
        }

        $year     = strftime("%Y");
        $insertar = "INSERT INTO solicitudes ( year, id_depto_sol, id_solicitud, id_depto_genera, cantidad, asunto, estado, id_usuario, fecha) VALUES ('$year','$deptoU', '$id_sol', " . $depa . ",'$cantidad','$asunto','Solicitado', '$IDU', NOW())";
        $exec     = mysqli_query($conexion, $insertar);

        if (!$exec) {
            echo "error " . mysqli_error($conexion);
        } else {

            echo "<script language='javascript'> alert('Solicitud realizada con éxito');  window.location.href='formsolicitar.php';</script>";
        }
    }
    if ($autoAutorizar == 1 ){
        // obtener el id solicitud
        $buscarIDSolicitud = mysqli_query($conexion, "SELECT MAX(id_solicitud) as id_solicitud from solicitudes WHERE id_usuario = '$IDU'");
        $ObtenerIDSolicitud = mysqli_fetch_array($buscarIDSolicitud);
        $idS = $ObtenerIDSolicitud['id_solicitud'];




        //if ($autorizar == 1){
            $actualizar = "UPDATE solicitudes SET estado = 'Autorizado' WHERE id_solicitud ='$idS'";
            $exec = mysqli_query($conexion, $actualizar);
            
            if(!$exec){
                echo "error".mysqli_error($conexion);
                echo "<script language='javascript'> alert('Error');  window.location.href='control.php';</script>";
            }
            else{
                //actualizar datos en la tabla solicitudes
                $actualizar = "UPDATE solicitudes SET id_usuario_auto = '$IDU', fecha_auto = NOW() WHERE id_solicitud ='$idS' ";
                $exec = mysqli_query($conexion, $actualizar);
                $generados = "Autorizados";
            }
        //}
        // else{
        //     $actualizar = "UPDATE solicitudes SET estado = 'Cancelado' WHERE id_solicitud ='$idS'";
        //     $exec = mysqli_query($conexion, $actualizar);
            
        //     if(!$exec){
        //         echo "error".mysqli_error($conexion);
        //         echo "<script language='javascript'> alert('Error');  window.location.href='control.php';</script>";
        //     }
        //     else{
        //         //actualizar datos en la tabla solicitudes
        //         $actualizar = "UPDATE solicitudes SET id_usuario_cancel = '$IDU', fecha_cancel = NOW() WHERE id_solicitud ='$idS' ";
        //         $exec = mysqli_query($conexion, $actualizar);
        //         $generados = "Cancelados";
                
        //     }
        // }
        // insertar los folios generados
        $consulta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_solicitud = '$idS'");
        if(!$consulta){
            echo "error: ".mysqli_error($conexion);
        }
        $cantidad= 0;
    
        while($datos=mysqli_fetch_array($consulta)){
            $anio_solicitud = $datos['year'];
            $cantidad = $datos['cantidad'];
            $fecha = $datos['fecha'];
            $idDS = $datos['id_depto_sol'];
            $idDaS = $datos['id_depto_genera'];
            $asunto = $datos['asunto'];
            $estado = $datos['estado'];
            $idU = $datos['id_usuario'];
            $idSoli = $datos['id_solicitud'];
    
            //seleccionar el último id folio con su año de solicitud
            $anioActual = strftime("%Y");
            $ultimo_folio = mysqli_query($conexion, "SELECT MAX(id_folio) as id_folio, year FROM folios WHERE id_depto_genera ='$idDaS' and year = '$anio_solicitud'");
            if(!$ultimo_folio){
                $folio = 0;
            }
            else{
                $idF = mysqli_fetch_array($ultimo_folio);
                if ($anioActual == $anio_solicitud){
                    $folio = $idF['id_folio'];
                }
                else{
                    $folio = 0;
                }
            }
    
            for ($i=0; $i < $cantidad; $i++) { 
                
                    $folio++;
              
                //obtener el id_folio para incrementarle 1
                $insertar = "INSERT INTO folios ( year ,id_depto_genera, id_folio, id_depto_sol, id_usuario,  id_solicitud, fecha, asunto, estado) VALUES ('$anio_solicitud','$idDaS', '$folio','$idDS', '$idU', '$idSoli', NOW(), '$asunto', '$estado')";
                $exec = mysqli_query($conexion, $insertar);
                if(!$exec){
                    echo $folio."<br>";
                    echo "<br>error al generar folios: ".mysqli_error($conexion);
                }
                else{
                    header("location: autorizar.php");
                }
            }        
        }    






    }




    mysqli_close($conexion);
}
