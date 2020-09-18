<?php
    $conexion=new  mysqli("localhost",'root',"1234",'bdgeneradorfolios');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Autorización de folios</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Autorizar solicitudes de folios</h2>
        <div>
            <table border="1">
                <tr>
                    <td>Solicitud No.</td>
                    <td>Fecha</td>
                    <td>Nombre del solicitante</td>
                    <td>Departamento que solicita</td>
                    <td>Departamento al que solicita</td>
                    <td>Asunto</td>
                    <td>Cantidad</td>
                    <td>Estado</td>
                    <td>Modificar</td>
                    <td>Autorizar</td>
                    <td>Cancelar</td>
                </tr>
                <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaS="SELECT * FROM solicitudes WHERE id_usuario = 1";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT id,id_depto, nombre, apellidos FROM usuarios WHERE id = 1";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= 1";
                $depto=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    echo "error".mysqli_error($conexion);
                }
                while($datos=mysqli_fetch_array($soli)){
                    //seleccionar el nombre del departamento al que se solicita el folio
                    $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datos['id_depto_a_sol'];
                    $deptoAS = mysqli_query($conexion,$consultaAS);
                    // revisar si el departamento al que solicitan es al que el usuario pertenece
                    foreach($nom as $n) {
                        if ($datos['id_depto_a_sol'] == $n['id']){

                ?>
                
                <tr>
                    <td><?php echo $datos['id_solicitud'];?></td>
                    <td><?php echo $datos['fecha'];?></td>
                    <td><?php foreach($nom as $n) {echo $n['nombre']." ".$n['apellidos'];} ?></td>
                    <td><?php foreach($depto as $d){echo $d['nombre_departamentos'];}?></td>
                    <td><?php foreach($deptoAS as $dAS) {echo $dAS['nombre_departamentos'];}?></td>
                    <td><?php echo $datos['asunto'];?></td>
                    <td><?php echo $datos['cantidad'];?></td>
                    <td><?php echo $datos['estado'];?></td>
                    <td>
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true" >
                            <input type="text" name="auto" value="1" hidden="true" > 
                            <?php if($datos['estado']=="pendiente"){ ?>                                                                                
                            <input type="submit" name="autorizar" value="Autorizar" > 
                            <?php } ?>
                        </form>
                    </td>                 
                    <td>
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true">
                            <input type="text" name="auto" value="0" hidden="true"> 
                            <?php if($datos['estado']=="pendiente"){ ?>  
                            <input type="submit" name="cancelar" value="Cancelar" >
                            <?php } ?>
                        </form>
                    </td>                 
                </tr>
                <?php
                        }
                    } 
                }  
                    mysqli_close($conexion);
                ?>
            </table>


        </div>
    </body>

</html>