<?php 
  session_start();
  require("3.php");
  $k1=new Kabe();
  $k1->loeSessioonist();
  $k1->t88tleURL();
?>
<!doctype html>
<html>
  <head>
    <title>Kabe</title>
  </head>
  <body>
     <?php
	   echo $k1->html();
	   echo $k1->andmedTekstina();
	 ?><br />
	 <a href="?uusmang=jah">Uus mäng</a>
  </body>
</html>