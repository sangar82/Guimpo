<?php

include_once("cform_construct.php");
include_once("cusers.php");
include_once("csesion.php");

class Cform_construct_login extends  Cform_construct 
{
	
	public $m_username;
	
	function Cform_construct_login($form_name = '',  $lng = 'es', $usr='')
	{
		$this->m_username = $usr;
		Cform_construct_login::Cform_construct($form_name, $lng);
	}
	
	
	function populate()
	{
		$this->m_form_object = new Cform($this->get_form_name(),$this->get_form_name(), htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES),'POST');		
		
		
		//Nombre de usuario
		$username = new Cform_text('username',$this->get_form_name().'_username','', '', '', 1, 'text', 3, 60, 25);
		$this->m_form_object->add_inputs($username, $username->get_id());
		
		
		// Password
		$password = new Cform_text('password',$this->get_form_name().'_password', '', '', '', 1, 'password', 6, 60, 25);
		$this->m_form_object->add_inputs($password, $password->get_id());
		

		// Boton de envio
		$submit_button = new Cform_button_submit('submit',$this->get_form_name().'_submit', 'Entrar', '');
		$this->m_form_object->add_inputs($submit_button, $submit_button->get_id());
		
		$this->m_form_object->close_form();
	}
	
	
	function process()
	{
		if (!isset($_POST[$this->m_form_name.'_submit'])){
		  
			$this->populate();
			
		}else {
		  
			//Creamos el formulario y le asignamos los valores
			$this->get_and_fill_submited_params();

			//validamos el formulario
			if ($this->validate())
			{
				//obtenemos los valores del formulario para hacer el save
				$user = $this->fill_array_to_save();
				
				//miramos si el usuario esta registrado
				$reg = Cusers::login_user( $user['username'], $user['password'] );
				
				if ($reg){
				  
				  $session = new Csesion();
				  
				  $result = $session->create($reg);
				  
				  Clocation::header_location('/admin/');
				  
				}else{
				  
				  	$this->set_info_action_form_failed('Login incorrecto. Vuelve a identificarte', 0);
				    Clocation::header_location('/login/');
				    exit();
				}
				
			}
		}
	}

	
	
	
}

?>
