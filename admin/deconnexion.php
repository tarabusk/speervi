<?php 
 // header('WWW-Authenticate: Basic realm="Déconnexion"');
 // header('HTTP/1.0 401 Unauthorized');
 // echo 'Texte utilis&eacute; si le visiteur utilise le bouton d\'annulation';
?>
<html>
  <head>
    <script type="text/javascript">
      function RedirectionJavascript(){
        document.location.href="http://reset:reset@localhost/speervi/admin";
      }
   </script>
  </head>
  <body onLoad="setTimeout('RedirectionJavascript()', 1000)">
  <?php 
  $_SERVER['PHP_AUTH_USER']='***';$_SERVER['PHP_AUTH_PW']='***';
  echo "<p>Bonjour, {$_SERVER['PHP_AUTH_USER']}.</p>";
  ?>
     <div>Dans 2 secondes vous allez être redirigé vers le site</div>
  </body>
</html>
<?php
/*
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Texte utilis&eacute; si le visiteur utilise le bouton d\'annulation';
    exit;
  } else {
   
    echo "<p>Bonjour, {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>Votre mot de passe est {$_SERVER['PHP_AUTH_PW']}.</p>";
	$_SERVER['PHP_AUTH_USER']='**';
	header
  }*/
?>