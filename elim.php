<?php
    
    $conexion=new  mysqli("localhost",'root',"1234",'bdgeneradorfolios');
    $id = $_POST['id_so'];

    $sql = "DELETE FROM solicitudes WHERE id_solicitud ='$id'";
    $consulta = mysqli_query($conexion,$sql);
    if(!$consulta){
        echo "error: ".mysqli_error($conexion);        
    }
    else{
        echo "Solicitud eliminada, link para volver al inicio";
    }
    mysqli_close($conexion);

?>