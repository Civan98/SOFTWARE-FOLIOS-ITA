<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="../css/forms.css">
</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" height="40" style=" margin-top: 50px; margin-bottom:50px;">
      <tr>
        <td bgcolor="#1B396A">
          <span style="font-family: 'Montserrat', sans-serif; font-weight: normal; font-style: normal; text-decoration: none; font-size: 10pt; color:white">
            &nbsp; <button class="menuopts" onclick="document.getElementById('id01').style.display='block'">Realizar registro</button>
            &nbsp; <button class="menuopts" onclick="document.getElementById('id02').style.display='block'">Iniciar sesión</button> 
            &nbsp;    <a href="https://tecnm.mx/" target=top>TecNM</a>  
            &nbsp;     <a href="https://sii.it-acapulco.edu.mx/" target=top>SII</a> 
            &nbsp;    <a href="https://login.microsoftonline.com/?whr=tecnm.mx/" target=top>Ingresa a tu correo</a>  
          </span> 
        </td>
        <td bgcolor="#1B396A">&nbsp;</td>
        <td bgcolor="#1B396A">&nbsp;</td>
     </tr>
    </table>

<!-- Modal registro -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Registro</h1>
      <p>Porfavor,rellene los siguientes campos</p>
      <hr>
      <label for="email"><b>Correo electrónico</b></label>
      <input type="text" placeholder="Introduzca un correo electrónico" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Introduzca una contraseña" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repita la contraseña" name="psw-repeat" required>

      <label>
        <input type="checkbox" checked="checked" name="remember">
         Recordarme
      </label>

      <div class="clearfix">
        <button type="submit" class="signup">Realizar registro</button>
      </div>
    </div>
  </form>
</div>
<!--Modal inicio de sesión -->

<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content" action="/action_page2.php">
    <div class="container">
      <h1>inicio de sesión</h1>
      <p>Porfavor,rellene los siguientes campos</p>
      <hr>
      <label for="email"><b>Correo electrónico</b></label>
      <input type="text" placeholder="Introduzca un correo electrónico" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Introduzca una contraseña" name="psw" required>

      <div class="clearfix">
        <button type="submit" class="signup">Realizar registro</button>
      </div>
    </div>
  </form>
</div>
</body>
</html>