<?php
    $idS = $_POST['id_so'];
    //$fecha = $_POST['fecha'];
    $deptoAS = $_POST['depto_a_Sol'];
    $cantidad = $_POST['cantidad'];
    $asunto = $_POST['asunto'];
    echo $idS." <br>".$deptoAS."<br>".$cantidad."<br>".$asunto; 

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
        //falta identificar los departamentos en la tabla departamentos
        //falta identificar el usuario, eso lo obtenemos con los datos del login
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

        $actualizar = "UPDATE solicitudes SET cantidad = '$cantidad', id_depto_genera = '$depa', asunto = '$asunto', id_usuario_edit = '$IDU', fecha_edit = NOW() WHERE id_solicitud ='$idS' ";
        $exec = mysqli_query($conexion, $actualizar);
            
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "<script language='javascript'> alert('Solicitud editada con éxito');  window.location.href='control.php';</script>";
        
        }
        mysqli_close($conexion);
    }

?>