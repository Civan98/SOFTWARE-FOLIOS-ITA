<?php

    $idS = $_POST['id'];
    $autorizar = $_POST['auto'];
    if ($autorizar==" "){
        $autorizar = 0;
    }

    //conexión
    $conexion=new  mysqli("localhost",'root',"1234","bdgeneradorfolios");
    //falta identificar los departamentos en la tabla departamentos
    //falta identificar el usuario, eso lo obtenemos con los datos del login
    //¿hacer que una vez cancelado una solicitud, ya no se pueda a autorizar?
    if ($autorizar == 1){
        $actualizar = "UPDATE solicitudes SET estado = 'autorizado' WHERE id_solicitud ='$idS'";
        $exec = mysqli_query($conexion, $actualizar);
        
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "Solicitud autorizada correctamente, *link a control o página principal*";
        }
    }
    else{
        $actualizar = "UPDATE solicitudes SET estado = 'cancelado' WHERE id_solicitud ='$idS'";
        $exec = mysqli_query($conexion, $actualizar);
        
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "Solicitud cancelada correctamente, *link a control o página principal*";
        }
    }
    // insertar los folios generados
    $consulta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_solicitud = '$idS'");
    if(!$consulta){
        echo "error: ".mysqli_error($conexion);
    }
    $cantidad= 0;
    while($datos=mysqli_fetch_array($consulta)){
        $cantidad = $datos['cantidad'];
        $fecha = $datos['fecha'];
        $idDS = $datos['id_depto_sol'];
        $idDaS = $datos['id_depto_a_sol'];
        $asunto = $datos['asunto'];
        $estado = $datos['estado'];
        $idU = $datos['id_usuario'];
        $idSoli = $datos['id_solicitud'];
        
        for ($i=0; $i < $cantidad; $i++) { 
            $insertar = "INSERT INTO folios (fecha, id_depto_sol, id_depto_a_sol, asunto, estado, id_usuario, id_solicitud) VALUES ('$fecha','$idDS','$idDaS', '$asunto', '$estado', '$idU','$idSoli')";
            $exec = mysqli_query($conexion, $insertar);
            if(!$exec){
                echo "error al generar folios: ".mysqli_error($conexion);
            }
            else{
                echo "folios generados *link a página principal*";
            }
        }
    }

   
    



    mysqli_close($conexion);
?>