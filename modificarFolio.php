<?php
$id = $_POST['id'];

$claves = explode(',', $id);

$year         = $claves[0];
$daS          = $claves[1];
$id_folio     = $claves[2];
$dS           = $claves[3];
$id_usuario   = $claves[4];
$id_solicitud = $claves[5];
$estado       = $claves[6];
$flag         = false;

if ($estado == "Autorizado") {
    $flag = true;
}

require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];

if (!isset($usuario)) {
    header("location: index.php");
} else {
    $q        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
    $consulta = mysqli_query($conexion, $q);
    $array    = mysqli_fetch_array($consulta);
    $IDU      = $array['id'];

    $q2        = "SELECT * from departamentos";
    $consulta2 = mysqli_query($conexion, $q2);

    // consulta para obtener el nombre del depa del usuario
    $q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
    $consulta3 = mysqli_query($conexion, $q3);
    $array3    = mysqli_fetch_array($consulta3);
    $depa      = $array3['nombre_departamentos'];

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modificar Folio</title>
        <meta charset="utf-8">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


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

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>

      </li>
      </a>
      <li>


           <a class="nav-link" href="autorizar.php">
            Volver
          <i class="fa fa-reply" aria-hidden="true"></i>

        </a>
        </li>

    </ul>
  </div>

</nav>


<div align="center">
        <h2>Modificar folios</h2>
            <?php
//seleccionar el folio deseado
$consultaS = "SELECT * FROM folios WHERE year = '$year' and id_depto_genera = '$daS' and id_folio = '$id_folio' and id_depto_sol = '$dS' and id_usuario = '$id_usuario' and id_solicitud= '$id_solicitud'";
$fol       = mysqli_query($conexion, $consultaS);

//seleccionar el nombre del usuario logeado
$consultaU = "SELECT nombre, apellidos FROM usuarios WHERE id = '$IDU'";
$nom       = mysqli_query($conexion, $consultaU);

//seleccionar el nombre del departamento del usuario logeado
$consultaD = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$dS'";
$depto     = mysqli_query($conexion, $consultaD);

//seleccionar el nombre del depto al que se le solicitan los folios
$consultaD = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$daS'";
$deptoAS   = mysqli_query($conexion, $consultaD);

if (!$fol) {
    echo "error" . mysqli_error($conexion);
    echo $id . " " . $ds . " " . $daS . " ";
}
$f         = mysqli_fetch_array($fol);
$n         = mysqli_fetch_array($nom);
$d         = mysqli_fetch_array($depto);
$depto_a_S = mysqli_fetch_array($deptoAS);

?>

<form action="modFolio.php" method="POST">
                <div class="form-group">
                <label for="Nfolio">Folio No.: <?php echo $f['id_folio']; ?> </label>
                <input class ="form-group" type="number" name="id_fo" value=<?php echo $f['id_folio']; ?> hidden="true" >
                <br>
                <br>
                <label for="fecha">Fecha:  <?php echo date("d-m-Y"); ?>  </label> <br><br>
                <!--<input type="date" id="fecha" name="fecha" value=<?php echo $f['fecha']; ?>><br><br> -->
                <label for="Nombre del solicitante">Nombre del solicitante: <?php echo $n['nombre'] . " " . $n['apellidos']; ?></label>
                 <br>
                 <br>
                <label for="Departamento que solicita">Departamento que solicita: <?php echo $d['nombre_departamentos']; ?> </label> <br>
                <br>
                <label for="Departamento al que solicita">Departamento al que solicita: <?php echo $depto_a_S['nombre_departamentos']; ?>
                 <br>
                 <br>
                <label for="Asunto">Asunto: <?php echo $f['asunto']; ?>  ---></label>
                <textarea  class="form-group" name="asunto" id="asunto" maxlength="100" cols="50" rows="5"><?php echo $f['asunto']; ?></textarea><br><br>
                <label for="Estado">Estado: <?php echo $f['estado']; ?></label> <br><br>
                <input type="text" name="id" value=<?php echo $f['year'] . "," . $f['id_depto_genera'] .
    "," . $f['id_folio'] . "," . $f['id_depto_sol'] . "," . $f['id_usuario'] .
    "," . $f['id_solicitud'] . "," . $f['asunto']; ?> hidden="true" >
                <input type="text" name="observacion" value="<?php echo $f['asunto']; ?> " hidden="true" >
                <input type="submit" name="modificar" id="modificar" value="Modificar" class="btn btn-primary btn-lg">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

            </div>
            </form>



        </div>
    </body>

</html>