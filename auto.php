<?php

    $idS = $_POST['id'];
    $autorizar = $_POST['auto'];
    $generados = "";
    // obtener el año de la solicitud, para que se autorice el folio con el año de la solicitud.
    $anioSolicitud = $_POST['anio'];
    date_default_timezone_set("America/Mexico_City");
    $tiempo = date('Y-m-d H:i:s');
    $anioActual       = strftime("%Y");

    

    if ($autorizar==""|| $idS == ""){
        header("location: autorizar.php");
    }

    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];
    $q = "SELECT * from usuarios where nombreUsuario = '$usuario' ";
    $consulta = mysqli_query($conexion,$q);
    $array = mysqli_fetch_array($consulta);
    $IDU = $array['id'];
    if ($autorizar == 1){
        $actualizar = "UPDATE solicitudes SET estado = 'Autorizado' WHERE id_solicitud ='$idS' and year = $anioSolicitud " ;
        $exec = mysqli_query($conexion, $actualizar);
        
        if(!$exec){
            echo "error".mysqli_error($conexion);
            echo "<script language='javascript'> alert('Error');  window.location.href='control.php';</script>";
        }
        else{
            //actualizar datos en la tabla solicitudes
            $actualizar = "UPDATE solicitudes SET id_usuario_auto = '$IDU', fecha_auto = '$tiempo' WHERE id_solicitud ='$idS' and year = $anioSolicitud ";
            $exec = mysqli_query($conexion, $actualizar);
            $generados = "Autorizados";
        }
    }
    else{
        $infoCancelar =  $_POST['infoCancelar'];
        $actualizar = "UPDATE solicitudes SET estado = 'Cancelado', observaciones = '$infoCancelar' WHERE id_solicitud ='$idS' and year = $anioSolicitud ";
        $exec = mysqli_query($conexion, $actualizar);
        //cancelar folios
        $actualizarFolios = "UPDATE folios SET estado = 'Cancelado', observaciones = '$infoCancelar' WHERE id_solicitud ='$idS' and year = $anioSolicitud ";
        $ejecutarActualizarFolios = mysqli_query($conexion, $actualizarFolios);
        
        if(!$exec){
            echo "error".mysqli_error($conexion);
            echo "<script language='javascript'> alert('Error');  window.location.href='control.php';</script>";
        }
        else{
            //actualizar datos en la tabla solicitudes
            $actualizar = "UPDATE solicitudes SET id_usuario_cancel = '$IDU', fecha_cancel = '$tiempo' WHERE id_solicitud ='$idS'and year = $anioSolicitud ";
            $exec = mysqli_query($conexion, $actualizar);
            $generados = "Cancelados";
            
        }
    }
    // insertar los folios generados
    $consulta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_solicitud = '$idS' and year = $anioSolicitud ");
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
            // este if, puede fallar, pues si autorizo folios de otro año, reiniciará el conteo de folios y dará error de duplicados. pero esto interfiere con el requerimiento de que los folios al cambiar de año comienzan desde cero.
            //PARA SOLUCIONAR, se debe quitar este if y dejar sólo $folio = $idF['id_folio'];
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
            $insertar = "INSERT INTO folios ( year ,id_depto_genera, id_folio, id_depto_sol, id_usuario,  id_solicitud, fecha, asunto, estado) VALUES ('$anio_solicitud','$idDaS', '$folio','$idDS', '$idU', '$idSoli', '$tiempo', '$asunto', '$estado')";
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

    mysqli_close($conexion);
?>