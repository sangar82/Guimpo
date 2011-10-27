<?php

include_once("cform.php");
include_once("clanguage.php");

class Cform_construct
{
	var $m_form_name;
	var $m_form_object;
	var $m_form_language;
	
	var $m_language;
	var $m_type;
	
	//var session control name
	var $m_sesion_name; 
	
	var $m_errors = array();

	
	function Cform_construct($form_name = "", $lng = "", $type = 'new')
	{
		$this->m_form_name 		 = $form_name;
		$this->m_form_language = $lng;
		
		//Creamos el objeto de lenguage
		$this->m_language = new Clanguage($lng);
		
		//definimos el tipo de formulario
		$this->m_type = $type;
	}
	
	
	function get_form_name()
	{
		return $this->m_form_name;
	}
	
	
	function set_form_language($language)
	{
		$this->m_form_language = $language;
		$this->m_language = new Clanguage($language);
	}
	
	
	function get_m_language()
	{
		return $this->m_language;
	}
	
	
	function get_type()
	{
		return $this->m_type;
	}
	
	
	function get_sesion_name()
	{
		return $this->m_sesion_name;
	}
	
	
	function get_mandatory_label()
	{
		return "&nbsp;&nbsp;(*)";
	}
	
	
	function set_sesion_name($value)
	{
		$this->m_sesion_name = $value;
	}

	
	function populate()
	{

	}
	
	
	function get_and_fill_submited_params()
	{
		//Creamos el formulario y llenamos los objetos del formulario
		$this->populate(false);
		
		//count the form name´s length
		$len=strlen($this->m_form_object->get_name()); 
		

		// Por cada uno de los objetos del formulario miramos si hay un $_request con la misma key y si es asi le ponemos el valor al objeto
		foreach ($this->m_form_object->get_objects() as $obj)
		{
			$name_obj = $obj->get_name();
			$type_obj = $obj->get_type();
			
			if (isset($_REQUEST[$name_obj]))
			{
				if ($type_obj != "info")
				{
					switch ( $obj->get_type() )
					{
						case "button":
						case "submit":
						case "info":
								break;
								
						case "checkbox":
							if ($_REQUEST[$name_obj] != 0)
								$obj->set_to_checked();
						break;
						
						case "select";
							$obj->set_to_selected(htmlentities(stripslashes($_REQUEST[$name_obj]),ENT_QUOTES, 'UTF-8'));
							$obj->set_value(htmlentities(stripslashes($_REQUEST[$name_obj]),ENT_QUOTES, 'UTF-8'));
							break;
							
						case "radio":
							$obj->set_to_checked(htmlentities(stripslashes($_REQUEST[$name_obj]),ENT_QUOTES, 'UTF-8'));
							break;
							
						default:
							$obj->set_value(htmlentities(stripslashes($_REQUEST[$name_obj]),ENT_QUOTES, 'UTF-8'));
						break;												
					}
									
					// Miramos si se ha enviado algun tipus file con el nombre del objeto
					if (isset($_FILES[$name_obj]))
					{
						$obj->set_value($_FILES[$name_obj]['name']);
					}
					
				}
			}
			else 
			{
				switch ( $obj->get_type() )
					{
						case "checkbox":
								$obj->set_to_unckecked();
						break;
																		
					}
			}
		}
		
		
	}
	
	function fill_array_to_save()
	{
		$to_save_array = array();
		// Por cada uno de los objetos del formulario lo ponemos en el array para poder hacer el save correspondiente
		foreach ($this->m_form_object->get_objects() as $obj)
		{

			$type_obj = $obj->get_type();
			
			switch ( $obj->get_type() )
			{
				case "button":
				case "submit":
				case "info":
						break;
						
				case "checkbox":
							$name_obj = $obj->get_name();
							$value = $obj->get_value();
							$name_without_formname = Cform_construct::get_name_obj_without_fornmame($name_obj);
				
							if ( $obj->is_checked() )
								$to_save_array[$name_without_formname] = $value ;
							else
								$to_save_array[$name_without_formname] = "" ;
				break;
				
				case "radio":
							$name_obj = $obj->get_name();
							$value = $obj->get_value();
							$name_without_formname = Cform_construct::get_name_obj_without_fornmame($name_obj);
				
							if ( $obj->is_checked() )
								$to_save_array[$name_without_formname] = $value ;
				break;
						
				default:
							$name_obj = $obj->get_name();
							$value = $obj->get_value();
							$name_without_formname = Cform_construct::get_name_obj_without_fornmame($name_obj);
				
							$to_save_array[$name_without_formname] = $value ;
				break;												
			}
			
		}
		
		return $to_save_array;
	}
	
	
	function fill_object_from_bd($resultat)
	{
		
		// Por cada uno de los objetos del formulario miramos si hay un $_request con la misma key y si es asi le ponemos el valor al objecto
		foreach ($this->m_form_object->get_objects() as $obj)
		{
			$name_obj = $obj->get_name();
			$name_without_formname = Cform_construct::get_name_obj_without_fornmame($name_obj);
			
			$type_obj = $obj->get_type();
			
			// Recojemos $_Request

				foreach( $resultat as $key => $value )
				{
					// Miramos que los objectos que recojemos pertenezcan al formulario
					

						if ($name_without_formname === $key)
						{
					
						     switch($type_obj){
						       
						       case 'radio':
						         $obj->set_to_checked($value);
						         break;
						         
						       case 'checkbox':						         	
						          if ($value)
								  $obj->set_to_checked();
								else 
								  $obj->set_to_unckecked();
								  
								$obj->set_value(1);
								
						         break;
						         
						       case 'select':
						         $obj->set_value($value);
						         $obj->set_to_selected($value);
						         break;
						         
						       case 'password':
						         $obj->set_value('');
						         break;
						         
						       case 'datepicker':
						          $obj->set_value(Cutils::to_spanish_dates($value));
						         break;
						         
						       case 'submit': 
						       case 'hidden':
						         break;
						         
						       default:
						         $obj->set_value($value);
						         break;
						         
						         
						         
						     }
						     
						     
						      
						  /*
							// Si es un radio no hemos de asignar valor porque ya lo tiene, si no elegir el que toca
							if ($type_obj == "radio")
							{
								$obj->set_to_checked($value);
							}
							else 
							{
								$obj->set_value($value);
							}
							
							//Si es un checkbox miramos si esta checked o no y lo asignamos
							if ($type_obj == "checkbox")
							{
							  if ($value)
								  $obj->set_to_checked();
								else 
								  $obj->set_to_unckecked();
								  
								$obj->set_value(1);
							}
							
							//si es un select buscamos si hay valor y ponemos el default
							if ($type_obj == "select")
							{
								$obj->set_to_selected($value);
							}
							
							//si es un objeto password, le ponemos un password por defecto que luego cambiaremos
							if ($type_obj == "password")
							{
								$obj->set_value('');
							}
							*/
						}
									
				}
		
		}
	}	
	
	
	function fill_objects_from_session_vars()
	{
		// Por cada uno de los objetos del formulario miramos en el array de sesion hay una variable con la misma key y si es asi le ponemos el valor al objecto
		foreach ($this->m_form_object->get_objects() as $obj)
		{
			$name_obj = $obj->get_name();
			$name_without_formname = Cform_construct::get_name_obj_without_fornmame($name_obj);
			
			$type_obj = $obj->get_type();
			
			if ($type_obj != "info")
			{
				//Creamos el objeto de sesion
				$sesion = new Csesion();
				$array_sesion = $sesion->get_var_session($this->get_sesion_name());
				
				foreach( $array_sesion[$this->get_form_name()] as $key => $value )
				{
					// Miramos que los objectos que recojemos pertenezcan al formulario

						if ($name_without_formname === $key)
						{
							// Si es un radio no hemos de asignar valor porque ya lo tiene, si no elegir el que toca
							if ($type_obj == "radio")
							{
								$obj->set_to_checked($value);
							}
							else 
							{
								$obj->set_value($value);
							}
						
							//Si es un checkbox miramos si esta checked o no y lo asignamos
							if ($type_obj == "checkbox")
							{
								$obj->set_to_checked();
							}
							
							//si es un select buscamos si hay valor y ponemos el default
							if ($type_obj == "select")
							{
								$obj->set_to_selected($value);
							}
							
							//si es un objeto password, le ponemos un password por defecto que luego cambiaremos
							if ($type_obj == "password")
							{
								$obj->set_value('');
							}
						}
									
				}
			}
		}	
	}
	
	
	function refresh_form_vars_sesion($array_values)
	{
		//Creamos el objeto session
			$sesion = new Csesion();
			
			// Comprobamos si existe la sesion 
			if ($sesion->exists($this->get_sesion_name()))
			{
				//Recojemos en un array toda la varaible de sesion para modificarla
				$sesion_actual = $sesion->get_var_session($this->get_sesion_name());
				
				//Modificamos el array con los nuevos datos
				$sesion_actual[$this->get_form_name()] = $array_values;
				
				$name = $this->get_sesion_name();
				// Guardamos el array en la variable de sesion
				$sesion->set_var_session($name, $sesion_actual);
			}
			else
			{
				//Creamos un contenedor para guardar en un array diferente los parametros de cada pagina
				$array_session = array();
				
				//añadimos al array contenedor los resultados validados con el nombre del formulario como key
				$array_session[$this->m_form_name] =  $array_values;
				
				
				$name = $this->get_sesion_name();
				//guardamos el array en la variable de sesion
				$sesion->set_var_session($name, $array_session);
			}
	}
	
	
	function complete_array_to_save_with_session_vars($array_values)
	{
		//creamos el objeto sesion
		$sesion = new Csesion();
		
		$form_session = $sesion->getSesio($this->get_sesion_name());
		
		foreach ($form_session as $form)
		{
			foreach ($form as $key=>$value)
			{
				$array_values[$key] =  $value;
			}
		}
		
		return $array_values;
	}
	
	
	function validate()
	{
		//obtenemos todos los objetos del formulario y los validamos uno por uno
		foreach ($this->m_form_object->get_objects() as $obj)
		{
			if (!$obj->validate())
			{
				$this->m_form_object->add_error($obj->get_name(), $obj->get_error_msg());
			}
		}
		
		//si hay errores en el array de errores el formulario no es valido
		if ( !count($this->m_form_object->get_array_errors()) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	function display()
	{
		$this->m_form_object->display();
	}
	
	
	function set_info_action_form_success($msg,$lng=1)
	{
		$language = $this->get_m_language();
		//setcookie('info_action', 1, time() + EXPIRE_COOKIES_MSG);
		//setcookie('info_msg', $msg, time() + EXPIRE_COOKIES_MSG);
	  $cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
		if($lng)
		{
	  	$msg_array = array('info_action' => 1, 'info_msg' => $language->get_element_generic($msg) );
		}
		else 
		{
			$msg_array = array('info_action' => 1, 'info_msg' => $msg );
		}
	  $cookie->WriteCookie($msg_array);
	}
	
	
	function set_info_action_form_failed($msg,$lng=1)
	{
		$language = $this->get_m_language();
		//setcookie('info_action', 0, time() + EXPIRE_COOKIES_MSG);
		//setcookie('info_msg', $msg, time() + EXPIRE_COOKIES_MSG);
	  $cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
	  if($lng)
	  {
			$msg_array = array('info_action' => 0, 'info_msg' => $language->get_element_generic($msg) );
	  }
	  else 
	  {
	  	$msg_array = array('info_action' => 0, 'info_msg' => $msg );
	  }
	  $cookie->WriteCookie($msg_array);
	}
	
	
	function set_info_action_form_number($msg)
	{
	  $cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
		$msg_array = array('info_action' => 1, 'info_msg' => $msg );
	  $cookie->WriteCookie($msg_array);
	}
	
	
	function get_form_object($name)
	{
		if (isset($this->m_form_object->m_objects[$name]))
		{
			return $this->m_form_object->m_objects[$name];
		}
		else 
		{
			return false;
		}
	}
	
	
	
	function get_form_label($name)
	{
		if (isset($this->m_form_object->m_array_labels[$name]))
		{
			return $this->m_form_object->m_array_labels[$name];
		}
		else 
		{
			return false;
		}
	}
	
	
	
	function open_form_display()
	{
		echo $this->m_form_object->open_form_errors()."\n";
		echo $this->m_form_object->display_array_errors()."\n";
		echo $this->m_form_object->close_form_errors()."\n";
		echo $this->m_form_object->open_form()."\n";
	}
	
	
	
	function close_form_display()
	{
		echo $this->m_form_object->close_form()."\n";
	}
	
	
	function get_name_obj_without_fornmame($name_obj){
	  
      $name_obj_mod = explode("_", $name_obj);
      
      if ($name_obj_mod[count($name_obj_mod) - 1] == 'ts'){
        return $name_obj_mod[count($name_obj_mod) - 1];
        die();
      }
      
      if ($this->get_form_name() == $name_obj_mod[0]."_".$name_obj_mod[1])
        $init = 2;
      else 
        $init = 1;
      
      $aux = '';
      $count = count($name_obj_mod);
      
      for ($i=$init; $i<$count; $i++){
        $aux .= $name_obj_mod[$i];
        
        if ($i + 1 < $count)
          $aux .= "_";
      }
        
        return $aux;
	}
	
	
	//TOKENS
	function validate_token(){
	  
        $token = isset($_POST['ts']) ? $_POST['ts'] : '';
        
        if( $token != md5($this->get_form_name().'t0k3n_ANTI_CSRF'.session_id()) ){
        	$this->loguejar_csrf('',md5($this->get_form_name().'t0k3n_ANTI_CSRF'.session_id()));
        }
        
	}
	
    function create_token(){
    
      $token = md5($this->get_form_name() . 't0k3n_ANTI_CSRF' . session_id());
      $csrf = new Cform_hidden('ts', 'ts', '', '', $token);
      $this->m_form_object->add_inputs($csrf,$csrf->get_id());
    
    }
    
    function loguejar_csrf($pagina='',$token_real){//[!]intent de jaking (CSRF)
	
      	if($pagina=='') $pagina = $this->obtenir_doc_php();
      	
      	//primer mirem si esta loguejat
      	$luser = false;
      	$ses = new Csesion();
      	
      	if($ses->check(true)){
      		$luser = $ses->get_var_session('username');
      	}
      	
      	echo "<span style='color:red'>Petición incorrecta. Ha habido cambios internos en el formulario</span>";
      	
      	$str_msg = "Intento de CSRF en '$pagina'. TOKEN valid = '$token_real'. ".(($luser)?"USERNAME:'".$luser."'":"");
      	
      	error_logger($str_msg,'ALERT','HACK');
      	
      	exit();
      }
      
      
      function obtenir_doc_php($url=''){
        
      	$php = ($url!='')?$url:htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES);
      	if(strpos($php,'/')!==false) 
      	{
      		$aux = explode('/',$php);
      		$php = $aux[count($aux)-1];
      	}	
      	return $php;
      	
      }
	

	
}

?>
