<?php
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
        echo "<hi> BIENVENIDO $usuario </h1><br>";
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];
        $deptoUsuario = $array['id_depto'];
        $conDepto = "SELECT * FROM departamentos WHERE id_depto ='$deptoUsuario'";
        $ejecutar = mysqli_query($conexion,$conDepto);
        $deptoU = mysqli_fetch_array($ejecutar);
        echo "<a href= 'logica/salir.php'> SALIR </a> ";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Solicitar folios</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <form action="solicitar.php" method="POST">
                <p>Solicitud de folios</p><br>
                <label for="fecha">Fecha: <?php date_default_timezone_set("America/Mexico_City"); echo date("d-m-Y");?> </label><br>
                <!--<input type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>"><br><br>-->
                <label for="deptoSol">Departamento que solicita: <?php echo $deptoU['nombre_departamentos']; ?></label>
                <br><br>
                <label for="deptoSol">Departamento a solicitar: </label>
                <select name="depto_a_Sol" id="listaDaS">
                    <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                    <option value="Arquitectura">Arquitectura</option>
                    <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                    <option value="Contador Público">Contador Público</option>
                    <option value="Ingeniería en Bioquímica">Ingeniería en Bioquímica</option>
                    <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
                    <option value="Ingeniería en Electromecánica">Ingeniería en Electromecánica</option>
                    <option value="Dirección">Dirección</option>
                    <option value="Subdirección">Subdirección</option>
                </select><br><br>
                <label for="cantidad">Cantidad: </label>
                <input type="number" name="cantidad" id="cantidad" min="1" pattern="^[0-9]+"><br><br>
                <label for="asunto">Asunto:</label>
                <textarea name="asunto" id="asunto" maxlength="100" cols="50" rows="5"></textarea><br><br>
                <input type="submit" name="enviar" id="enviar">
            </form>

        </div>
    </body>

</html>