<?php
 
include_once("cform_construct.php");
include_once("cusers.php");
include_once("cimagen.php");
include_once("cmail.php");


class Cform_construct_user extends  Cform_construct {

  var $m_user_id; 
	
  
	function Cform_construct_user($form_name = '', $lng = 'es', $type = 'new', $user_id = ''){
	  
	  $this->m_user_id = $user_id;
	  
		Cform_construct_user::Cform_construct($form_name, $lng, $type);
	}
	
	
	function get_user_id(){
	  return $this->m_user_id;
	}
	
	
	function populate($fillbd = true)
	{
		$this->m_form_object = new Cform($this->get_form_name(),$this->get_form_name(),htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES),'post');
		
		// Username
		$username = new Cform_text('username',$this->get_form_name().'_username','','', '', 1, 'text', 5, 60, 60);
		$this->m_form_object->add_inputs($username,$username->get_id());
		
		
		// Password
		if ($this->m_type == 'new')
		  $password = new Cform_text('password',$this->get_form_name().'_password', '', '', '',1,'password', 6, 60, 60);
		else 
		  $password = new Cform_text('password',$this->get_form_name().'_password', '', '', '',0,'password', 6, 60, 60);
		  
		$this->m_form_object->add_inputs($password,$password->get_id());
		
		
		if($this->get_type()=="new")
			$re_password=new Cform_text('re_password',$this->get_form_name().'_re_password','password_again','','',1,'password',6,60,60);
		else 
			$re_password=new Cform_text('re_password',$this->get_form_name().'_re_password','password_again','','',0,'password',6,60,60);
    
		$this->m_form_object->add_inputs($re_password,$re_password->get_id());
		

		// Nombre
		$name = new Cform_text('name',$this->get_form_name().'_name', '', '', '', 0, 'text', 3, 60, 60);
		$this->m_form_object->add_inputs($name,$name->get_id());
		

		// lastname
		$lastname = new Cform_text('lastname',$this->get_form_name().'_lastname', '', '', '', 0, 'text',0,60,60);
		$this->m_form_object->add_inputs($lastname,$lastname->get_id());
		
		
		
		//hidden id usuario para el edit
		if ($this->m_type == 'edit'){
		  $user_id = new Cform_hidden('user_id', $this->get_form_name().'_user_id', '', '', $this->m_user_id);
		  $this->m_form_object->add_inputs($user_id,$user_id->get_id());
		}  

		
		// Boton de envio
		$submit_button = new Cform_button_submit('submit',$this->get_form_name().'_submit','Enviar');
		$this->m_form_object->add_inputs($submit_button,$submit_button->get_id());
		
		
		$this->m_form_object->close_form();
		
		
		// si es un edit llenamos los objetos con los campos de la base de datos
		if ($this->get_type() == "edit" and $fillbd)
		{
			$this->search_and_fill_object_from_bd();
		}
		
	}
	
	function process(){
	  
		if (!isset($_POST[$this->m_form_name.'_submit'])){
		  
			$this->populate();
			
		}else{
      
			//Creamos el formulario y le asignamos los valores
			$this->get_and_fill_submited_params();
			
			//validamos el formulario
			if ($this->validate()){
			  
				//obtenemos los valores del formulario para hacer el save
				$user = $this->fill_array_to_save();
							  
				
				if ($this->m_type == "new"){
          
				  if($user['password']==$user['re_password']){
				  
    				//creamos el objeto cusers
    				$newuser = new Cusers('', $user['username'], $user['password'], $user['name'], $user['lastname']);
    				
    				// guardamos el objeto
    				if ($newuser->save()){
      				
      			   $this->set_info_action_form_success('Usuario guardado correctamente', 0);
      			   Clocation::header_location('/admin/users/list/');
  				     exit();
    					
    				}else {
    					
    				  $this->set_info_action_form_failed('Error creando al usuario', 0);
  				    Clocation::header_location('/admin/users/list/');
  				    exit(); 
  				  }
  				  
				  }else{
				      $this->set_info_action_form_failed('El password no coincide', 0);
  				    Clocation::header_location('/admin/users/list/');
  				    exit(); 
				  }
						
				}else if ($this->m_type == "edit") {
				 
				  //Obtenemos el usuario
				  $edituser = new Cusers($user['user_id']);
				  		  
				  if ($user['password'] != ""){
				    
						if($user['password']==$user['re_password']){
				  
              $edituser->edit($user['name'] , $user['lastname'], $user['username'], $user['password']);
              
						}else{
						  
				      $this->set_info_action_form_failed('El password no coincide', 0);
  				    Clocation::header_location('/admin/users/list/');
  				    exit(); 						  
  				    
						}
   
				  }else{
				    
				    $edituser->edit($user['name'] , $user['lastname'], $user['username'], '');
				  }
				  
				  
				  if ($edituser){
				    
				    $this->set_info_action_form_success('Usuario editado correctamente', 0);
				    Clocation::header_location('/admin/users/list/');
				    exit();
				    
				    
				  }else{
				    
				    $this->set_info_action_form_failed('Error editando al usuario', 0);
				    Clocation::header_location('/admin/users/list/');
				    exit();
				    
				  }
				  
				  
				} //edit
		  } //validate
    }
	}
	
	
	function search_and_fill_object_from_bd()
	{
		// Buscamos en la base de datos los usuarios
		$usuari = new Cusers($this->get_user_id());
		$resultat = $usuari->load_user_to_array();
	
		
		// Llenamos el objeto formulario con los valores de la bd
		$this->fill_object_from_bd($resultat);
	}
		
}

?>
