<?php
require 'logica/conexion.php';
session_start();
$usuario       = $_SESSION['username'];
$qDepto        = "SELECT * from departamentos";
$consultaDepto = mysqli_query($conexion, $qDepto);

if (!isset($usuario)) {
    session_destroy();
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

    $q2        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
    $consulta2 = mysqli_query($conexion, $q2);
    $array2    = mysqli_fetch_array($consulta2);
    $depa      = $array2['nombre_departamentos'];

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
      <a class="navbar-brand" href="#"> <?php echo "Departamento: $depa" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <span class="navbar-brand" style="margin-left: 5%;">
      Solicitud de folios
    </span>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="#">
            <?php echo "Usuario: $usuario"; ?>
         </a>

      </li>

      <li class="nav-item">


           <a class="nav-link" href="control.php">
            Control
          <i class="fa fa-address-book" aria-hidden="true"></i>


        </a>
        </li>


      <li class="nav-item">


           <a class="nav-link active" href="#">
            Solicitar
            <span class="sr-only">(current)</span>
          <i class="fa fa-wrench" aria-hidden="true"></i>

        </a>
        </li>

        <li>


           <a class="nav-link" href="autorizar.php">
            Autorizar
          <i class="fa fa-bolt" aria-hidden="true"></i>

        </a>
        </li>

        <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>
        </a>

      </li>


    </ul>
  </div>

</nav>


        <div align="center" style="margin: 10px;">
            <form action="solicitar.php" method="POST">
                <div class="form-group">
                <h1>Solicitud de folios</h1>
                <label for="fecha">Fecha: <?php date_default_timezone_set("America/Mexico_City");
echo date("d-m-Y");
$Year = strftime("%Y");?> </label><br>
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

                <br><br>
                <label for="cantidad">Cantidad: </label>
                <input type="number" name="cantidad" id="cantidad" min="1" pattern="^[0-9]+" style="width: 5%;"><br><br>
                <label for="asunto">Asunto:</label>
                <textarea name="asunto" id="asunto" maxlength="100" cols="50" rows="5" style="width: 43%;"></textarea><br><br>
                <button type="submit" name="enviar" id="enviar" class="btn btn-primary btn-lg">Enviar</button>
            </div>
            </form>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </body>

</html>