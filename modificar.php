<?php
    $id = $_POST['id'];
    $dS = $_POST['dS'];
    $daS = $_POST['daS'];
    //$conexion=new  mysqli("localhost",'root',"1234",'bdgeneradorfolios');
     require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];
        echo "<hi> BIENVENIDO $usuario </h1><br>";

       echo "<a href= 'logica/salir.php'> SALIR </a> ";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modificar solicitud de folios</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Modificar solicitudes de folios</h2>
        <div>
            
            <?php

                // echo "datos:". $id." ".$dS." ".$daS." ";
                //seleccionar la solicitud deseada                
                $consultaS="SELECT * FROM solicitudes WHERE id_solicitud = '$id'";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT nombre, apellidos FROM usuarios WHERE id = '$IDU'";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$dS'";
                $depto=mysqli_query($conexion, $consultaD);

                //seleccionar el nombre del depto al que se le solicitan los folios
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$daS'";
                $deptoAS=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    echo "error".mysqli_error($conexion);
                    echo $id." ".$ds." ".$daS." ";
                }
                $s = mysqli_fetch_array($soli);
                $n = mysqli_fetch_array($nom);
                $d = mysqli_fetch_array($depto);
                $depto_a_S = mysqli_fetch_array($deptoAS);
                
            ?>
            <form action="mod.php" method="POST">
                <label for="Nsolicitud">Solicitud No.: <?php echo $s['id_solicitud'];?> </label> <input type="number" name="id_so" value=<?php echo $s['id_solicitud'];?> hidden="true"><br><br>
                <label for="fecha">Fecha:  <?php echo date("d-m-Y");?>  </label> <br><br>
                <!--<input type="date" id="fecha" name="fecha" value=<?php echo $s['fecha'];?>><br><br> -->
                <label for="Nombre del solicitante">Nombre del solicitante: <?php echo $n['nombre'].$n['apellidos']; ?></label> <br><br>
                <label for="Departamento que solicita">Departamento que solicita: <?php echo $d['nombre_departamentos']; ?> </label> <br><br>
                <label for="Departamento al que solicita">Departamento al que solicita: <?php echo $depto_a_S['nombre_departamentos'];?>  ---></label>
                <select name="depto_a_Sol" id="listaDaS">
                    <!-- seleccionar por defecto el depto ya guardado -->
                    <option value="<?php echo $depto_a_S['nombre_departamentos']; ?> " selected> <?php echo $depto_a_S['nombre_departamentos'];?> </option>
                    <option value="Ingeniería en Sistemas Computacionales" >Ingeniería en Sistemas Computacionales</option>
                    <option value="Arquitectura">Arquitectura</option>
                    <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                    <option value="Contador Público">Contador Público</option>
                    <option value="Ingeniería en Bioquímica">Ingeniería en Bioquímica</option>
                    <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
                    <option value="Ingeniería en Electromecánica">Ingeniería en Electromecánica</option>
                    <option value="Dirección">Dirección</option>
                    <option value="Subdirección">Subdirección</option>
                </select><br><br> 
                <label for="Asunto">Asunto: <?php echo $s['asunto'];?>  ---></label>
                <textarea name="asunto" id="asunto" maxlength="100" cols="50" rows="5" ><?php echo $s['asunto'];?></textarea><br><br> 
                <label for="Cantidad">Cantidad: <?php echo $s['cantidad'];?>  ---></label>
                <input type="number" name="cantidad" id="cantidad" min="1" pattern="^[0-9]+" value= <?php echo $s['cantidad'];?> ><br><br> 
                <label for="Estado">Estado: <?php echo $s['estado'];?></label> <br><br>
                <input type="submit" name="modificar" id="modificar" value="Modificar">
            </form>


        </div>
    </body>

</html>