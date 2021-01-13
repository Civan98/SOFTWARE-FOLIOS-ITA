<?php
    $idS = $_POST['id_so'];
    $deptoAS = $_POST['depto_a_Sol'];
    $cantidad = $_POST['cantidad'];
    $asunto = $_POST['asunto'];
    $anioSolicitud = $_POST['anio'];
    // echo $idS." <br>".$deptoAS."<br>".$cantidad."<br>".$asunto. "año $anioSolicitud"; 
    date_default_timezone_set("America/Mexico_City");
    $tiempo = date('Y-m-d H:i:s');
    $anioActual       = strftime("%Y");

    if ($idS=="" || $deptoAS=="" || $cantidad ==""||$asunto==""){
        header("location: control.php");
        }
    else{
        require 'logica/conexion.php';
        session_start();
        $usuario = $_SESSION['username'];
        if(!$conexion){
            echo "Falla en la conexión";
        }else{
            $bd = mysqli_select_db($conexion, 'bdgeneradorfolios');
            if(!$bd){
                echo "no se encontró la base de datos";
            }
        }
// seleccionar la solicitud con su id y el año en que se solicitó
        $asuntoAnterior = "SELECT  * FROM solicitudes WHERE id_solicitud = '$idS' and year = $anioSolicitud";
        $ejecutarAsuntoAnterior = mysqli_query($conexion, $asuntoAnterior);
        $obtenerObservacion = mysqli_fetch_array($ejecutarAsuntoAnterior);
        $observacion = $obtenerObservacion['asunto'];
        $estado = $obtenerObservacion['estado'];
        

        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];    
    
        $buscarDeptoAS = mysqli_query($conexion, "SELECT id_depto FROM departamentos WHERE nombre_departamentos = '$deptoAS'");
        if(!$buscarDeptoAS){
            echo "error: ".mysqli_error($conexion);
        }
        $depa= "";
        foreach($buscarDeptoAS as $DaS){
            $depa = $DaS['id_depto'];
            }

        
        $actualizar = "UPDATE solicitudes SET cantidad = '$cantidad', id_depto_genera = '$depa', asunto = '$asunto', id_usuario_edit = '$IDU', fecha_edit = '$tiempo', observaciones='$observacion' WHERE id_solicitud ='$idS' and year = $anioSolicitud";
        $exec = mysqli_query($conexion, $actualizar);
        //ojo, si está cancelado,porque no hay folios con estado cancelado aún
        if ($estado == 'Cancelado'|| $estado == 'Autorizado') {
            // echo 'mod folios';
            $actualizarFolios = "UPDATE folios SET asunto = '$asunto', observaciones='$observacion' WHERE id_solicitud ='$idS' and year = $anioSolicitud";
            $ejecutarActualizarFolios = mysqli_query($conexion, $actualizarFolios);
            if(!$ejecutarActualizarFolios){
                echo "error".mysqli_error($conexion);
            }
            
        }
            
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "<script language='javascript'> alert('Solicitud editada con éxito');  window.location.href='control.php';</script>";
        
        }
        mysqli_close($conexion);
    }

?>