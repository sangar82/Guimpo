<?php 



$form = $this->get_form_by_name('cformusers');
$form->open_form_display();

if ($this->get_var('form_type') == 'new')
  echo "<h1>Crear usuario</h1>";
else
  echo "<h1>Editar usuario</h1>";
  
  
echo "<table class='formtable'>";

  echo "<tr>";
    echo "<td>Username</td>";
    echo "<td> ". $form->get_form_object('username')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td width='150'>Password</td>";
    echo "<td> ". $form->get_form_object('password')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td>Repite el password</td>";
    echo "<td> ". $form->get_form_object('re_password')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td>Name</td>";
    echo "<td> ". $form->get_form_object('name')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td>Lastname</td>";
    echo "<td> ". $form->get_form_object('lastname')->display(true) ." </td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td colspan='2'>";
    
      if ($this->get_var('form_type') == 'edit'){
        
        echo  $form->get_form_object('user_id')->display(true);
        
      }    
      echo  $form->get_form_object('submit')->display(true);
      
      echo "&nbsp;&nbsp; <a href='/admin/users_list.php'>Volver atrás</a>";
    echo "</td>";
  echo "</tr>";
  
  
  
echo "</table>";

$form->close_form_display();


?>