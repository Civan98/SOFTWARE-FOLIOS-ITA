<?php
require 'logica/conexion.php';
session_start();
$usuario       = $_SESSION['username'];
$qDepto        = "SELECT * from departamentos";
$consultaDepto = mysqli_query($conexion, $qDepto);

if (!isset($usuario)) {
    header("location: index.php");
} else {

    $q            = "SELECT * from usuarios where nombreUsuario = '$usuario' ";
    $consulta     = mysqli_query($conexion, $q);
    $array        = mysqli_fetch_array($consulta);
    $IDU          = $array['id'];
    $deptoUsuario = $array['id_depto'];
    $conDepto     = "SELECT * FROM departamentos WHERE id_depto ='$deptoUsuario'";
    $ejecutar     = mysqli_query($conexion, $conDepto);
    $deptoU       = mysqli_fetch_array($ejecutar);

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Solicitar folios</title>
        <meta charset="utf-8">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    </head>
    <body>
    <div align="center">
    <img src=imagenes/header.png width="850" height="133">
    </div>

      <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "BIENVENIDO $usuario" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>

      </li>
      </a>
            <li>


           <a class="nav-link" href="solicitar.php">
            Solicitar
          <i class="fa fa-wrench" aria-hidden="true"></i>

        </a>
        </li>

        <li>


           <a class="nav-link" href="autorizar.php">
            Autorizar
          <i class="fa fa-bolt" aria-hidden="true"></i>

        </a>
        </li>

        <li>


           <a class="nav-link" href="control.php">
            Volver
          <i class="fa fa-reply" aria-hidden="true"></i>

        </a>
        </li>
     <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            aaa
         </a>
      </li>
     -->
    </ul>
  </div>

</nav>


        <div align="center" style="margin: 10px;">
            <form action="solicitar.php" method="POST">
                <div class="form-group">
                <h1>Solicitud de folios</h1>
                <label for="fecha">Fecha: <?php date_default_timezone_set("America/Mexico_City");
echo date("d-m-Y"); $Year = strftime("%Y"); echo $Year; ?> </label><br>
                <!--<input type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>"><br><br>-->
                <label for="deptoSol">Departamento que solicita: <?php echo $deptoU['nombre_departamentos']; ?></label>
                <br><br>
                <label for="deptoSol">Departamento a solicitar: </label>
                <select id="inputState" class="form-control" name="depto_a_Sol" style="width: 33%;">
            <?php
//Consulta para rellenar el combobox
$indice = 0;
while ($row = mysqli_fetch_array($consultaDepto)) {
    $indice++;
    $depto = $row['nombre_departamentos'];
    ?>
                <option value="<?php echo $depto ?>">
                    <?php echo $indice . ' - ' . $depto ?>
                    </option>
                <?php
}
?>
            </select>
                <!--<select name="depto_a_Sol" id="listaDaS">
                    <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                    <option value="Arquitectura">Arquitectura</option>
                    <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                    <option value="Contador Público">Contador Público</option>
                    <option value="Ingeniería en Bioquímica">Ingeniería en Bioquímica</option>
                    <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
                    <option value="Ingeniería en Electromecánica">Ingeniería en Electromecánica</option>
                    <option value="Dirección">Dirección</option>
                    <option value="Subdirección">Subdirección</option>
                </select>-->

                <br><br>
                <label for="cantidad">Cantidad: </label>
                <input type="number" name="cantidad" id="cantidad" min="1" pattern="^[0-9]+" style="width: 5%;"><br><br>
                <label for="asunto">Asunto:</label>
                <textarea name="asunto" id="asunto" maxlength="100" cols="50" rows="5" style="width: 43%;"></textarea><br><br>
                <button type="submit" name="enviar" id="enviar" class="btn btn-primary btn-lg">Enviar</button>
            </div>
            </form>

        </div>
    </body>

</html>