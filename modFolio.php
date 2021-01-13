<?php
    $id     = $_POST['id'];

    $claves = explode(',', $id);
    
    $year= $claves[0];
    $deptoAS= $claves[1];
    $id_folio = $claves[2];
    $dS= $claves[3];
    $id_usuario= $claves[4];
    $id_solicitud= $claves[5];
    //atención a este asunto
    $observacion = $_POST['observacion'];
    // echo $observacion;
    $asunto = $_POST['asunto'];



    date_default_timezone_set("America/Mexico_City");
    $tiempo = date('Y-m-d H:i:s');
    $anioActual       = strftime("%Y");


    // $idS = $_POST['id_so'];
    // $deptoAS = $_POST['depto_a_Sol'];
    // $cantidad = $_POST['cantidad'];
    // $asunto = $_POST['asunto'];


    // echo $idS." <br>".$deptoAS."<br>".$cantidad."<br>".$asunto; 

    if ($asunto==""){
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

        // $asuntoAnterior = "SELECT  * FROM solicitudes WHERE id_solicitud = '$idS'";
        // $ejecutarAsuntoAnterior = mysqli_query($conexion, $asuntoAnterior);
        // $obtenerObservacion = mysqli_fetch_array($ejecutarAsuntoAnterior);
        // $observacion = $obtenerObservacion['asunto'];

        // $estado = $obtenerObservacion['estado'];
        

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

        $actualizar = "UPDATE folios SET asunto = '$asunto', usuario_edit = '$IDU', fecha_edit = '$tiempo', observaciones='$observacion' WHERE year = '$year' and id_depto_genera = '$deptoAS' and id_folio = '$id_folio' and id_depto_sol = '$dS' and id_usuario = '$id_usuario' and id_solicitud= '$id_solicitud'";
        $exec = mysqli_query($conexion, $actualizar);        
            
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "<script language='javascript'> alert('Folio editado con éxito');  window.location.href='autorizar.php';</script>";
        
        }
        mysqli_close($conexion);
    }

?>