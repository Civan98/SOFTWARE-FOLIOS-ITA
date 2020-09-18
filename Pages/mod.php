<?php
    $idS = $_POST['id_so'];
    $fecha = $_POST['fecha'];
    $deptoAS = $_POST['depto_a_Sol'];
    $cantidad = $_POST['cantidad'];
    $asunto = $_POST['asunto'];
  echo $idS." <br>",$fecha."<br><br>".$deptoAS."<br>".$cantidad."<br>".$asunto; 

    $conexion=new  mysqli("localhost",'root',"1234");
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
    
    $buscarDeptoAS = mysqli_query($conexion, "SELECT id_depto FROM departamentos WHERE nombre_departamentos = '$deptoAS'");
    if(!$buscarDeptoAS){
        echo "error: ".mysqli_error($conexion);
    }
    $depa= "";
    foreach($buscarDeptoAS as $DaS){
        $depa = $DaS['id_depto'];
        }

    $actualizar = "UPDATE solicitudes SET cantidad = '$cantidad', id_depto_a_sol = '$depa', asunto = '$asunto', fecha = '$fecha' WHERE id_solicitud ='$idS' ";
    $exec = mysqli_query($conexion, $actualizar);
    
    if(!$exec){
        echo "error".mysqli_error($conexion);
    }
    else{
        echo "datos Modificados correctamente, *link a control o página principal*";
    }
    mysqli_close($conexion);

?>