<?php

    $idS = $_POST['id'];
    $autorizar = $_POST['auto'];
    $generados = "";
    if ($autorizar==""|| $idS == ""){
        header("location: autorizar.php");
    }

    //conexión
    //$conexion=new  mysqli("localhost",'root',"1234","bdgeneradorfolios");
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];
    $q = "SELECT * from usuarios where nombreUsuario = '$usuario' ";
    $consulta = mysqli_query($conexion,$q);
    $array = mysqli_fetch_array($consulta);
    $IDU = $array['id'];
    //falta identificar los departamentos en la tabla departamentos
    
    //¿hacer que una vez cancelado una solicitud, ya no se pueda a autorizar?
    if ($autorizar == 1){
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
            //echo "<script language='javascript'> alert('Solicitud AUTORIZADA con éxito');  window.location.href='autorizar.php';</script>";
        }
    }
    else{
        $actualizar = "UPDATE solicitudes SET estado = 'Cancelado' WHERE id_solicitud ='$idS'";
        $exec = mysqli_query($conexion, $actualizar);
        
        if(!$exec){
            echo "error".mysqli_error($conexion);
            echo "<script language='javascript'> alert('Error');  window.location.href='control.php';</script>";
        }
        else{
            //actualizar datos en la tabla solicitudes
            $actualizar = "UPDATE solicitudes SET id_usuario_cancel = '$IDU', fecha_cancel = NOW() WHERE id_solicitud ='$idS' ";
            $exec = mysqli_query($conexion, $actualizar);
            $generados = "Cancelados";
            //echo "<script language='javascript'> alert('Solicitud CANCELADA con éxito');  window.location.href='autorizar.php';</script>";
        }
    }
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




        //verificar que los folios sean del mismo depto para que esos folios los números sean consecutivos
/*         if($idDS==$idDaS){
            $ultimo_folio = mysqli_query($conexion, "SELECT MAX(id_folio) as id_folio FROM folios WHERE id_depto_genera ='$idDaS' and id_depto_sol = '$idDaS'");
            if(!$ultimo_folio){
                $folio = 0;
            }
            else{
                $idF = mysqli_fetch_array($ultimo_folio);
                $folio = $idF['id_folio'];
            }

            for ($i=0; $i < $cantidad; $i++) { 
                $folio++;
                //obtener el id_folio para incrementarle 1
                $insertar = "INSERT INTO folios (id_depto_genera, id_folio, id_depto_sol, id_usuario,  id_solicitud, fecha, asunto, estado) VALUES ('$idDaS', '$folio','$idDS', '$idU', '$idSoli', CURDATE(), '$asunto', '$estado')";
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
        else{
            $ultimo_folioD = mysqli_query($conexion, "SELECT MAX(id_folio) as id_folioD FROM folios WHERE (id_depto_genera <> '$idDS' and id_depto_sol <> '$idDS')");
            if(!$ultimo_folioD){
                $folioD = 0;
            }
            else{
                $idFD = mysqli_fetch_array($ultimo_folioD);
                $folioD = $idFD['id_folioD'];
            }
            for ($i=0; $i < $cantidad; $i++) { 
                $folioD++;
                //obtener el id_folio para incrementarle 1
                $insertar = "INSERT INTO folios (id_depto_genera, id_folio, id_depto_sol, id_usuario,  id_solicitud, fecha, asunto, estado) VALUES ('$idDaS', '$folioD','$idDS', '$idU', '$idSoli', CURDATE(), '$asunto', '$estado')";
                $exec = mysqli_query($conexion, $insertar);
                if(!$exec){
                    echo $folio."<br>";
                    echo "<br>error al generar folios: ".mysqli_error($conexion);
                }
                else{
                    header("location: autorizar.php");
                }
            }


        } */
    
        
    }
    

    mysqli_close($conexion);
?>