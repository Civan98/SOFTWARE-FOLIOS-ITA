<!DOCTYPE html>
 <html lang="es">

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TecNM | Tecnológico Nacional de México Campus Acapulco</title>
    <link rel="stylesheet" type="text/css" href="css/gral.css">
</head>


<body>

<div align="center">

  <img src=imagenes/pleca-gob2.png width="270" height="83">
	<img src=imagenes/TecNM_logo.png width="167" height="83"></div>
      
  <div align="center"><span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 16pt; color:gray">
   Tecnológico Nacional de México Campus Acapulco<br>  </span>    
  <br><br> 
</div>

<div align="center">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" height="40" >
      <tr>
        <td bgcolor="#1B396A">
          <span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 10pt; color:white">
            &nbsp;   <a href=".">Inicio</a> 
            &nbsp;     <a href="http://acapulco.tecnm.mx/" target=top>Mi Tec</a> 
            &nbsp;    <a href="https://tecnm.mx/" target=top>TecNM</a>  
            &nbsp;     <a href="https://sii.it-acapulco.edu.mx/" target=top>SII</a> 
            &nbsp;    <a href="https://login.microsoftonline.com/?whr=tecnm.mx/" target=top>Ingresa a tu correo</a>  
          </span> 
        </td>
        <td bgcolor="#1B396A">&nbsp;</td>
        <td bgcolor="#1B396A">&nbsp;</td>
     </tr>
    </table>
    <br><br><br><br>

<div class="contacto">
    <?php 

      function GenerarFolio(){
          $dia = date("d");
          $dia--;
      
            for ($i = 1; $i <= 2; $i++) {
              $folio1 = rand(0,9);
              $folio2 = rand(0,9);
          }

          $folio = $dia.date("m").date("o").$folio1.$folio2;
          echo "Folio ".$folio;
      }

      GenerarFolio(); 
  
    ?>
</div>
  <br><br>  <br><br>


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
</body>
</html> 