<?php

include_once("cform_construct.php");
include_once("cusers.php");
include_once("cimagen.php");
include_once("cmailing.php");


class Cform_construct_user extends  Cform_construct {

  var $m_user_id; 
  var $m_layout;
	
  
	function Cform_construct_user($form_name = '', $lng = 'es', $type = 'new', $user_id = '', $layout = 'backend'){
	  
	  $this->m_user_id = $user_id;
	  $this->m_layout		= $layout;
	  
	  $this->set_sesion_name('user');
	  
		Cform_construct_user::Cform_construct($form_name, $lng, $type);
	}
	
	
	function get_user_id(){
	  return $this->m_user_id;
	}
	
	
	function populate($fillbd = true)
	{
		$this->m_form_object = new Cform($this->get_form_name(),$this->get_form_name(),htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES),'post');
		
		/*
		// Username
		$username = new Cform_text('username',$this->get_form_name().'_username','','', '', 1, 'text', 5, 60, 60);
		$this->m_form_object->add_inputs($username,$username->get_id());
		*/
		
		// email and username
		$email = new Cform_text('email',$this->get_form_name().'_email','email','', '', 1, 'text', 5, 60, 60);
		$this->m_form_object->add_inputs($email,$email->get_id());
		
		
		if($this->get_type()=="new")
			$reemail = new Cform_text('re_email',$this->get_form_name().'_re_email','email email_again','', '', 1, 'text', 5, 60, 60);
		else	
			$reemail = new Cform_text('re_email',$this->get_form_name().'_re_email','email email_again','', '', 0, 'text', 5, 60, 60);
			
		$this->m_form_object->add_inputs($reemail,$reemail->get_id());			
		
		
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
		
			
		
		if($this->m_layout =="backend"){
			$type = new Cform_select('type', $this->get_form_name().'_type', '', '', 1);
				$type->add_option('admin', 'Admin');
				$type->add_option('user', 'User');
		} else{
			$type = new Cform_hidden('type', $this->get_form_name().'_type', '', '', 'user');
		}
		$this->m_form_object->add_inputs($type,$type->get_id());
		
			

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
		
		
		/* COMPROVAMOS SI YA EXISTE UNA SESION CREADA DE ESTE FORMULARIO */
		if ($this->exist_sesion_vars_for_this_form()){
			$this->fill_objects_from_session_vars();
		}
		else{
			// si es un edit llenamos los objetos con los campos de la base de datos
			if ($this->get_type() == "edit" and $fillbd){
				$this->search_and_fill_object_from_bd();
			}
		}
		
	}
	
	function process(){
	  
		if (!isset($_POST[$this->m_form_name.'_submit'])){
		  
			$this->populate();
			
		}else{
			
			//Definimos la ruta de redirección
			if ($this->m_layout == "backend"){
				
				$path_redirection = "/admin/users/list/";
				
			}else{
				
				$path_redirection = "/login/";
				
			}
      
			//Creamos el formulario y le asignamos los valores
			$this->get_and_fill_submited_params();
			
			//validamos el formulario
			if ($this->validate()){
			  
				//obtenemos los valores del formulario para hacer el save
				$user = $this->fill_array_to_save();
				
				//Actualizamos la variable de sesion del formulario con los nuevos datos
				$this->refresh_form_vars_sesion($user);
							  
				//Controlamos que el nombre de usuario no se pueda repetir
				if ( isset($user['user_id']) )
					$uid = $user['user_id'];
				else 
					$uid = '';
				
					if (!Cusers::is_unique($user['email'], $uid )){
							
							if ( ($this->m_layout == "backend") ){
								
										if ($this->m_type == "new"){
											$path_red = "/admin/users/create/";
										} else {
											$path_red = "/admin/users/edit/$uid/";
										}
								
							} else {
								$path_red = "/newuser/";
							}
							

							$this->set_info_action_form_failed('El nombre de usuario ya está siendo utilizado. Escoge otro', 0);
						 	Clocation::header_location($path_red);
  				    exit(); 
					} else {
						$sesion = new Csesion();
						$sesion->delete_var_session('user');
					} 
				
				
				if ($this->m_type == "new"){
					
				  if($user['password'] == $user['re_password'] and $user['email'] == $user['re_email']){
				  
    				//creamos el objeto cusers
    				$newuser = new Cusers('', $user['email'], $user['password'], $user['name'], $user['lastname'], $user['email'], $user['type']);
    				
    				// guardamos el objeto
    				if ($newuser->save()){
    					
    					//enviamos un email al nuevo usuario
							$text = "
						      <table align='center' width='526'>
								<tr>
								  <td style='font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:16px;' align='left'>". DOMAIN ."</td>
								</tr>
						      </table>	
						      
						      <table width='526' align='center' style='border:1px solid #cdcdcd;font-family: lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;line-height:20px;margin-top:15px;' cellpadding='10'>
						        <tr>
						          <td>
						              ". $this->m_language->translate('hola') ."<br/><br/>
						              ". $this->m_language->translate('intro_new_user') ."<br/>
						              <b>". $this->m_language->translate('email') .":</b> ".$user['email']."<br/>
						              <b>". $this->m_language->translate('password') .":</b> ".$user['password']."<br/><br/>
						              ". $this->m_language->translate('mgracias') ."<br />
						              ". $this->m_language->translate('grettings', array(DOMAIN)) ."
						              
						          </td>
						        </tr>
						        <tr>
						          <td><font size='1'><br>". $this->m_language->translate('no_reply') ."</font></td>
						        </tr>
						      </table>";
						
							$mailing = new Cmailing('new_user@'.DOMAIN, $user['email'], $this->m_language->translate('subject_new_user', array(DOMAIN) ), $text);
							$email_sended = $mailing->send();    					 
      				
      			   $this->set_info_action_form_success('Usuario guardado correctamente', 0);
      			   Clocation::header_location($path_redirection);
  				     exit();
    					
    				}else {
    					
    				  $this->set_info_action_form_failed('Error creando al usuario', 0);
  				    Clocation::header_location($path_redirection);
  				    exit(); 
  				  }
  				  
				  }else{
				  		
				  	if($user['password'] != $user['re_password'] and $user['email'] != $user['re_email'])
				      	$this->set_info_action_form_failed('El password y el email no coinciden', 0);
				    else  if($user['password'] != $user['re_password'] )
				    		$this->set_info_action_form_failed('El password no coincide', 0);
				    else  if( $user['email'] != $user['re_email'] )
				    		$this->set_info_action_form_failed('El email no coincide', 0);
				    		    
  				    Clocation::header_location($path_redirection);
  				    exit(); 
				  }
						
				}else if ($this->m_type == "edit") {
				 
				  //Obtenemos el usuario
				  $edituser = new Cusers($user['user_id']);
				  		  
				  if ($user['password'] != ""){
				    
						if($user['password']==$user['re_password']){
				  
              $edituser->edit($user['name'] , $user['lastname'], $user['email'], $user['password'], $user['email'], $user['type']);
              
						}else{
				      $this->set_info_action_form_failed('El password no coincide', 0);
  				    Clocation::header_location($path_redirection);
  				    exit(); 						  
						}
   
				  }else{ 
				    $edituser->edit($user['name'] , $user['lastname'], $user['email'], $user['password'], $user['email'], $user['type']);
				  }
				  
				  if ($edituser){
				    
				    $this->set_info_action_form_success('Usuario editado correctamente', 0);
				    Clocation::header_location($path_redirection);
				    exit();
				    
				  }else{
				    
				    $this->set_info_action_form_failed('Error editando al usuario', 0);
				    Clocation::header_location($path_redirection);
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
	
	function exist_sesion_vars_for_this_form()
	{
		$resultat = false;
		$sesion = new Csesion();
		
		if ($sesion->exists($this->get_sesion_name()))
		{
			$sesion_array = $sesion->get_var_session($this->get_sesion_name());
			
			$resultat = isset($sesion_array[$this->get_form_name()]);
		}
		
		return $resultat;
	}
		
}

?>
