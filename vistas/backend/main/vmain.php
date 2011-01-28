<?php 

$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );

echo "<h1>Framework</h1>";

if ($con->connection){
  echo "<div class='info_ok'>Estás conectado a la BD</div>";

  echo "<br>Puedes crear scaffolds! <a href='/scaffolds'>Ir a scaffolds</a>";
  
}else 
  echo "<div class='info_ko'>Error conectando a la BD. Revisa config.php</div>";

?>