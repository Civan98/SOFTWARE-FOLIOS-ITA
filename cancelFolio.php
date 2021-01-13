<?php
    $id     = $_POST['id'];
    $observacion = $_POST['infoCancelar'];
    $claves = explode(',', $id);
    
    $year= $claves[0];
    $deptoAS= $claves[1];
    $id_folio = $claves[2];
    $dS= $claves[3];
    $id_usuario= $claves[4];
    $id_solicitud= $claves[5];
    //atención a este asunto
   
    //fecha y año actual
    date_default_timezone_set("America/Mexico_City");
    $tiempo = date('Y-m-d H:i:s');
    $anioActual       = strftime("%Y");
    

    echo " sad  $observacion"; 

    if ($observacion==""){
        // header("location: autorizar.php");
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

        $actualizar = "UPDATE folios SET usuario_cancel = '$IDU', fecha_cancel = '$tiempo', estado='Cancelado',  observaciones='$observacion' WHERE year = '$year' and id_depto_genera = '$deptoAS' and id_folio = '$id_folio' and id_depto_sol = '$dS' and id_usuario = '$id_usuario' and id_solicitud= '$id_solicitud'";
        $exec = mysqli_query($conexion, $actualizar);        
            
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "<script language='javascript'> alert('Folio CANCELADO con éxito');  window.location.href='autorizar.php';</script>";
        
        }
        mysqli_close($conexion);
    }

?>