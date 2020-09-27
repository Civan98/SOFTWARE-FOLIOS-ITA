<?php
    // redirecciona a control si hay una sesion activa
    require 'logica/conexion.php';
    session_start();
    if(isset($_SESSION['username'])){
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
   Tecnológico Nacional de México Campus Acapulco<br>  
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
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="signup.php">Iniciar sesión</a>
      <a class="nav-item nav-link" href="register.php">Registrarse</a>
    </div>
  </div>
  </nav>
  </div>



  <img src="imagenes/fachada.jpg" alt="Fachada" width="850" height="533">
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