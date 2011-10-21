<?php

$form = $this->get_form_by_name('cformlogin'); 
$form->open_form_display();

//Web informacino
//echo $this->get_web_information('login');

echo $this->get_web_information(); 


echo "<div class='login_box_container'>"; 
	
	//Box nuevos usuarios
	echo "<div class='login_box_left'>";
	
		echo "<div class='login_box_top'>
			". $this->translate('newuser') ."
		</div>";
		
		echo "<div class='login_box_cont login_box_cont_new'>";
		
					//nuevos usuarios			
					echo "<h3>". $this->translate('newuserl') ."</h3>
					<p> ". $this->translate('newusert') ."</p><br>";
					
					echo "<a href='/newuser/' class='create rfloat'>". $this->translate('create_new_user')."</a>";

		echo "</div>";
		
	echo "</div>";
	
	//Box usuarios registrados
	echo "<div class='login_box_right'>";
	
		echo "<div class='login_box_top'>
			". $this->translate('userreg') ."
		</div>";
		
		echo "<div class='login_box_cont'>";
	
			
			echo "<table cellspaccing='5' cellpadding='5'>";
			
				echo "<tr>";
					echo "<td width='160px'>";
						echo "".$this->translate('username')."";
					echo "</td>";
					echo "<td>";
						echo " ". $form->get_form_object('username')->display(true) ." ";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "".$this->translate('password')."";
					echo "</td>";
					echo "<td>";
						echo "<div>". $form->get_form_object('password')->display(true) ."</div>";
						echo "<span class='helper'> <a href='/reminder_password/'>".$this->get_language()->get_element_generic('forgotpassword')."</a> </span>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td align='right'>". $form->get_form_object('submit')->display(true) ."</td>";
				echo "<tr>";
				
			echo "</table>";
		

			//echo "<input type='hidden' name='ref' value=\"$referer\">";
		
		
		
		
		echo "</div>";
		
	echo "</div>";

echo "</div>";

?>
