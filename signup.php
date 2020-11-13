<?php
//funcion para cuando haya un usuario no se loge de nuevo
require 'logica/conexion.php';
session_start();
if (isset($_SESSION['username'])) {
    header("location: control.php");
}
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

</head>


<body>
<div align="center">
  <img src=imagenes/header.png width="850" height="133"></div>

  <div align="center"><span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 16pt; color:gray">
   Sistema de Control de Folios<br>
 </span>
</div>

<div align="center">

 <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="index.php">Home </a>
      <a class="nav-item nav-link active" href="#">Iniciar sesión <span class="sr-only">(current)</span> </a>

    </div>
  </div>

  </div>

</nav>

 <div class="container">
  <div class="border" style="padding: 10px;">
  <h1>Inicio de sesión</h1>
  <h2>Porfavor, introduzca sus credenciales:</h2>
<form action="logica/loguear.php" method="POST">
  <div class="form-group">
    <label for="username">Usuario</label>
    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Usuario" name="usuario" required>
    <!--<small id="emailHelp" class="form-text text-muted"></small>-->
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="clave" required>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Recordar usuario</label>
  </div>
  <br>
  <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
</form>
</div>
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
