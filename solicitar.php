<?php
    $fecha = $_POST['fecha'];
    //$deptoS = $_POST['depto_Sol'];
    $deptoAS = $_POST['depto_a_Sol'];
    $cantidad = $_POST['cantidad'];
    $asunto = $_POST['asunto'];

    if ($fecha=="" || $deptoAS=="" || $cantidad=="" || $asunto ==""){
        header("location: formsolicitar.php");
    }
    else{
    echo $fecha."<br>".$deptoS."<br>".$deptoAS."<br>".$cantidad."<br>".$asunto; 

    //$conexion=new  mysqli("localhost",'root',"");
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];
    if(!$conexion){
        echo "Falla en la conexión";
    }else{
        $bd = mysqli_select_db($conexion, 'bdgeneradorfolios');
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];
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
    $insertar = "INSERT INTO solicitudes (cantidad, id_depto_sol, id_depto_a_sol, asunto, estado, id_usuario, fecha) VALUES ('$cantidad', '$IDU', ".$depa.",'$asunto','pendiente', '$IDU', '$fecha')";
    $exec = mysqli_query($conexion, $insertar);
    
    if(!$exec){
        echo "error".mysqli_error($conexion);
    }
    else{
        echo "datos insertados *link a página principal*";
        header("location: control.php");
    }
    mysqli_close($conexion);
    }

?>