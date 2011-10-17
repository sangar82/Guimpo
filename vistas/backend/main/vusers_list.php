<?php 
$users = $this->get_var('users');

echo $this->get_web_information(); 


echo "<h1>". $this->translate('list_of', array($this->translate('users')))."</h1>";

if ($users){

  echo "<table class='formattable'>";
  
    echo "<thead>";
      echo "<th>". $this->translate('username')."</th>";
      echo "<th>". $this->translate('name')."</th>";
      echo "<th>". $this->translate('lastname')."</th>";
      echo "<th>". $this->translate('created')."</th>";
      echo "<th>". $this->translate('updated')."</th>";
      echo "<th colspan='3'>". $this->translate('options')."</th>";
      
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($users as $user) { 
      
      echo "<tr>";
  
        echo "<td>".$user['username']."</td>";
        echo "<td>".$user['name']."</td>";
        echo "<td>".$user['lastname']."</td>";
        echo "<td>".$user['created']."</td>";
        echo "<td>".$user['updated']."</td>";
        echo "<td><a href='/admin/users/".$user['id']."/'>".$this->translate('view')."</a></td>";
        echo "<td><a href='/admin/users/edit/".$user['id']."/'>".$this->translate('modify')."</a></td>";
        echo "<td><a href='/admin/users/delete/".$user['id']."/' onclick=\"return confirm('".$this->translate('confirm_delete')."');\">".$this->translate('delete')."</a></td>";
        
      echo "</tr>";
      
    }
    echo "</tbody>";
    
  echo "</table>";
  
  echo "<br /><br />";

  echo "<a href='/admin/users/create/'>". $this->translate('new_item')."</a>";

}else 
  echo "". $this->translate('no_items')." <a href='/admin/users/create/'>". $this->translate('new_item')."</a>";
  
  echo "<br><br><a href='/admin/'>". $this->translate('return_to_menu')."</a>";


?>