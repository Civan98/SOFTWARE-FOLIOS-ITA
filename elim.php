<?php
    
    $conexion=new  mysqli("localhost",'root',"",'bdgeneradorfolios');
    $mysqli->set_charset("utf8");
    //require 'logica/conexion.php';
    //session_start();
    $id = $_POST['id_so'];
    // posiblemente sólo quiere que se ponga el estado como eliminado, no eliminar de verdad
    $sql = "DELETE FROM solicitudes WHERE id_solicitud ='$id'";
    $consulta = mysqli_query($conexion,$sql);
    if(!$consulta){
        echo "error: ".mysqli_error($conexion);        
    }
    else{
       // echo "Solicitud eliminada, link para volver al inicio";
        header("location: control.php");
    }
    mysqli_close($conexion);

?>