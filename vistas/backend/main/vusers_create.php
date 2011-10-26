<?php 

$form = $this->get_form_by_name('cformusers');
$form->open_form_display();

if ($this->get_var('form_type') == 'new')
  echo "<h1>". $this->translate('cuser') ."</h1>";
else
  echo "<h1>". $this->translate('uuser') ."</h1>";
  
  
echo "<table class='formtable'>";

  echo "<tr>";
    echo "<td> ". $this->translate('username') ." </td>";
    echo "<td> ". $form->get_form_object('username')->display(true) ." </td>";
  echo "</tr>";

  if ($this->get_var('form_type') == 'new'){

		  echo "<tr>";
		    echo "<td width='150'> ". $this->translate('password') ." </td>";
		    echo "<td> ". $form->get_form_object('password')->display(true) ." </td>";
		  echo "</tr>";
  
  } else {
  	
  		echo "<tr>";
		    echo "<td width='150'> ". $this->translate('password') ." </td>";
		    echo "<td>";
		    	echo " <div>". $form->get_form_object('password')->display(true) ." </div>";
		    	echo "<span class='helper'> ".$this->get_language()->get_element_generic('password_info')." </span>";
		    echo "</td>";
		  echo "</tr>";
  	
  }

  echo "<tr>";
    echo "<td> ". $this->translate('repite_password') ." </td>";
    echo "<td> ";
    	echo "<div> ". $form->get_form_object('re_password')->display(true) ."</div>";
    	echo "<span class='helper'> ".$this->get_language()->get_element_generic('repassword_info')." </span>";
    echo " </td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td> ". $this->translate('email') ." </td>";
    echo "<td> ". $form->get_form_object('email')->display(true) ." </td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td> ". $this->translate('repite_email') ." </td>";
    echo "<td>";
    	echo  "<div>". $form->get_form_object('re_email')->display(true) . "</div>";
    	echo "<span class='helper'> ".$this->get_language()->get_element_generic('reemail_info')." </span>";
    	echo " </td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td> ". $this->translate('type') ." </td>";
    echo "<td> ". $form->get_form_object('type')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td> ". $this->translate('name') ." </td>";
    echo "<td> ". $form->get_form_object('name')->display(true) ." </td>";
  echo "</tr>";

  echo "<tr>";
    echo "<td> ". $this->translate('lastname') ." </td>";
    echo "<td> ". $form->get_form_object('lastname')->display(true) ." </td>";
  echo "</tr>";
  
  echo "<tr>";
    echo "<td colspan='2'>";
    
      if ($this->get_var('form_type') == 'edit'){
        
        echo  $form->get_form_object('user_id')->display(true);
        
      }    
      echo  $form->get_form_object('submit')->display(true);
      
      echo "&nbsp;&nbsp; <a href='/admin/users_list.php' class='return'>". $this->translate("volver_atras") ."</a>";
    echo "</td>";
  echo "</tr>";
  
  
  
echo "</table>";

$form->close_form_display();


?>