<?php 

$item = $this->get_var('item');

echo "<h1>Ver usuario</h1>";

echo "<b>Username: </b> ".$item['username']."<br />";
echo "<b>Password: </b> ".$item['password']."<br />";
echo "<b>Name: </b> ".$item['name']."<br />";
echo "<b>Lastname: </b> ".$item['lastname']."<br />";
echo "<b>Creación: </b> ".$item['created']."<br />";
echo "<b>Update: </b> ".$item['updated']."<br />";

echo "<br /><br /> <a href='/admin/users_list.php'>Volver atrás</a>";  

  
?>

