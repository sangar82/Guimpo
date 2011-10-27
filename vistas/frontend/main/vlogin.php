<?php 

$form = $this->get_form_by_name('cformlogin'); 
$form->open_form_display();

echo "<div id='loginbox'>";
echo $this->get_web_information(); 
  echo "<h1>".$this->translate('identificate')."</h1><br/>" ;

  echo "<table class=''signtable>";
  
  	echo "<tr>";
  		echo "<td width='160'>".$this->translate('username')."</td>"; 
  		echo "<td> ". $form->get_form_object('username')->display(true) ." </td>"; 
  	echo "</tr>"; 
  
  	echo "<tr>";
  		echo "<td>".$this->translate('password')."</td>"; 
  		echo "<td> ". $form->get_form_object('password')->display(true) ." </td>"; 
  	echo "</tr>"; 
  
  
  	echo "<tr>"; 
  	  echo "<td>&nbsp;</td>";
  		echo "<td align='right'>";
  		  echo  $form->get_form_object('submit')->display(true);
  		echo "</td>"; 
  	echo "</tr>";
  
  echo "</table>";

echo "</div>";

$form->close_form_display();

?>
