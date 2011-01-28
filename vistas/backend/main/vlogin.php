<?php 

echo $this->get_web_information(); 

echo '<h1>Login</h1>' ;

$form = $this->get_form_by_name('cformlogin'); 
$form->open_form_display();

echo "<table>";

	echo "<tr>";
		echo "<td width='100'>Username</td>"; 
		echo "<td> ". $form->get_form_object('username')->display(true) ." </td>"; 
	echo "</tr>"; 

	echo "<tr>";
		echo "<td>Password</td>"; 
		echo "<td> ". $form->get_form_object('password')->display(true) ." </td>"; 
	echo "</tr>"; 


	echo "<tr>"; 
		echo "<td colspan='2'>";
		  echo  $form->get_form_object('submit')->display(true);
		echo "</td>"; 
	echo "</tr>";

echo "</table>";

$form->close_form_display();

?>
