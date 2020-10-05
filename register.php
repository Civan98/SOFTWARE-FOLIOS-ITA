<?php
require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];

$q        = "SELECT * from departamentos";
$consulta = mysqli_query($conexion, $q);

$q2        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
$consulta2 = mysqli_query($conexion, $q2);
$array     = mysqli_fetch_array($consulta2);
$admin     = $array['admin'];

// consulta para obtener el nombre del depa del usuario
$q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
$consulta3 = mysqli_query($conexion, $q3);
$array3    = mysqli_fetch_array($consulta3);
$depa      = $array3['nombre_departamentos'];

//se valida que haya usuario en sesion

if (!isset($usuario)) {
    session_destroy();
    header("location: index.php");
} else {
    if ($admin == 0) {
        //valida que el usuario no sea admin
        session_destroy();
        header("location: index.php");
    } else {

        ?>
<!DOCTYPE html>
 <html lang="es">

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TecNM | Tecnológico Nacional de México Campus Acapulco</title>
    <link rel="stylesheet" type="text/css" href="css/gral.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

</head>


<body>
<div align="center">
  <img src=imagenes/header.png width="850" height="133"></div>

  <div align="center"><span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 16pt; color:gray">
   Tecnológico Nacional de México Campus Acapulco<br>
 </span>
</div>

<div align="center">

 <div class="container" style="margin-top: 20px; margin-bottom: 20px;">

 <div class="container">
  <div class="border" style="padding: 10px;">
  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "Departamento: $depa" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">

        <a class="nav-link" href="#">
            <?php echo "Usuario: $usuario"; ?>
         </a>

      </li>
      <!--validación del admin-->
      <?php if ($admin == 1) {?>
          <li class="nav-item">
            <a class="nav-link active" href="register.php">
              <span class="sr-only">(current)</span>
                <?php echo "Adminstrador"; ?>
                <i class="fa fa-pencil" aria-hidden="true"></i>

            </a>

          </li>
    <?php }?>

      <li class="nav-item">


           <a class="nav-link" href="control.php">
            Control
          <i class="fa fa-address-book" aria-hidden="true"></i>


        </a>
        </li>


      <li class="nav-item">


           <a class="nav-link" href="formsolicitar.php">
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

        <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>
        </a>

      </li>

    </ul>
  </div>

</nav>


  <h1>Registro de usuario</h1>
  <h2>Porfavor, introduzca los datos solicitados:</h2>
<form action ="insert.php" method ="POST">
<div class="row">

  <div class="col">
    <label for="nombre">Nombre:</label>
          <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre" required>
  </div>

  <div class="col-4">
      <label for="Apellidos">Apellidos:</label>
        <input type="text" class="form-control" placeholder="Apellidos" id="Apellidos" name="Apellidos" required>
      </div>

  <div class="col">
    <label for="NombreUsuario">Nombre de usuario:</label>
        <input type="text" class="form-control" placeholder="Nombre de usuario" id="NombreUsuario" name="NombreUsuario" required>
  </div>

</div>

    <div class="row">
  <div class="col">
    <label for="cargo">Cargo:</label>
    <input type="text" class="form-control" placeholder="Cargo" id="cargo"  name="cargo">
  </div>

  <div class="col">
    <label for="cargo">Administrador:</label>
          <select  id="inputState" class="form-control" name="administrador" >
            <option value="1">Si</option>
            <option value="0">No</option>
          </select>
  </div>

      <div class="col">
        <label for="departamento">Departamento:</label>
        <select id="inputState" class="form-control" name="departamento">
        <?php
//Consulta para rellenar el combobox
        $indice = 0;
        while ($row = mysqli_fetch_array($consulta)) {
            $indice++;
            $depto = $row['nombre_departamentos'];
            ?>
              <option value="<?php echo $depto ?>"> <?php echo $indice . ' - ' . $depto ?></option>
            <?php
}
        ?>
        </select>
      </div>


    </div>

          <div class="row">
        <div class="col">
          <label for="password">Contraseña:</label>
          <input type="password" name="password" id="password" name="password" placeholder="Contraseña" class="form-control" required>
        </div>

        <div class="col">
           <label for="passwordretry">Confirmar contraseña:</label>
          <input type="password" name="passwordretry" id="passwordretry" name="passwordretry" placeholder="Confirmar Contraseña" class="form-control" required>
        </div>
      </div>
      <br>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
</form>
</div>
</div>

<div class="contacto">
  <p align="center">
  <span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 14pt; color:#254ca7">
  Contacto</span>

    <table border="0" align="center" width="50%">
      <tr>
        <td ><div align="center"><img src="imagenes/mail.png" width="78" height="78"></div></td>
        <td >&nbsp;</td>
        <td ><div align="center"><img src="imagenes/fb.png" width="78" height="78"></div></td>
      </tr>
      <tr>
        <td><div align="center"><div align="center"><span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 10pt; color:gray"> vinculacion@acapulco.tecnm.mx</span></div></div></td>
        <td><div align="center"></div></td>
        <td><div align="center"><a href="https://www.facebook.com/vinculacion.acapulco/" target="top"><div align="center"><span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 10pt; color:gray"> @vinculacion.acapulco</span></div></a></div></td>
      </tr>
    </table>
</div>


 <hr width="80%">

 <div class="pie">
    <span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 8pt; color:gray">
    <span id="copyright_osvp">ITA - ALGUNOS DERECHOS RESERVADOS © 2019 <br>
          TecNM | Tecnológico Nacional de México Campus Acapulco<br>
          Instituto Tecnológico de Acapulco<br>
          Av. Instituto Tecnológico s/n Crucero del Cayaco C.P. 39905 <br>
      vin_acapulco@tecnm.mx, <br>
    Teléfonos (744) 442-9010 ext 120 </span></p>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>
<?php }?>

<?php }?>