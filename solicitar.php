<?php
    $fecha = $_POST['fecha'];
    $deptoS = $_POST['depto_Sol'];
    $deptoAS = $_POST['depto_a_Sol'];
    $cantidad = $_POST['cantidad'];
    $asunto = $_POST['asunto'];
  echo $fecha."<br>".$deptoS."<br>".$deptoAS."<br>".$cantidad."<br>".$asunto; 

    $conexion=new  mysqli("localhost",'root',"");
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
        //colocar el id del departamento al que pertenece el usuario de forma dinámica con datos del login, igual el id del usuario con los datos del login
    $insertar = "INSERT INTO solicitudes (cantidad, id_depto_sol, id_depto_a_sol, asunto, estado, id_usuario, fecha) VALUES ('$cantidad', '1', ".$depa.",'$asunto','pendiente', 1, '$fecha')";
    $exec = mysqli_query($conexion, $insertar);
    
    if(!$exec){
        echo "error".mysqli_error($conexion);
    }
    else{
        echo "datos insertados *link a página principal*";
    }
    mysqli_close($conexion);

?>