<?php
include_once("cform_file.php");

class Cform_doc extends Cform_file
{
  
  var $m_valid_extensions = array();
  
	//Constructor
	function Cform_doc($id, $name, $class = '', $label = '', $value = '', $mandatory = 0, $valid_extensions = 'pdf,doc', $type = 'file', $minlenght = 5, $maxlenght = 100, $size = 30)
	{
	  
	  //obtenemos las extensiones validas
	  $extensions = explode(",", $valid_extensions);
	  
	  foreach ($extensions as $extension){
	    array_push($this->m_valid_extensions, $extension);
	  }
	  
	  
	  
		Cform_doc::Cform_file($id, $name, $class, $label, $value, $mandatory, "file", $minlenght, $maxlenght, $size);
		
		$this->add_class("image");
			
	}
	

		/**
	* validate()
	* @return bool
	*/
		
	function validate(){
		$noerror = 1;
		
		if ( isset($_FILES[$this->m_name]['name']) )
		  $name = $_FILES[$this->m_name]['name'];
		else 
		  $name = "";
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory)
		{
			// Si es obligatorio miramos que no sea nulo
			if ($name)
			{

				if ( !in_array($this->get_file_extension($name), $this->m_valid_extensions) )
				{
					// Asignamos al atributo error_msg el mensaje de error
					$error_msg = "not_file_extension_allowed";
					$this->set_error_msg($error_msg);
					
					// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
					$this->set_error_class();
					
					$noerror = 0;
				}
				
			}
			else
			{
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "text_field_null";
				$this->set_error_msg($error_msg);
				
				// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
				$this->set_error_class();
				
				$noerror = 0;
			}			
		}
		else 
		{
			
			if ($name){
			
  			if ( !in_array($this->get_file_extension($name), $this->m_valid_extensions) ){
  				// Asignamos al atributo error_msg el mensaje de error
  				$error_msg = "not_file_extension_allowed";
  				$this->set_error_msg($error_msg);
  				
  				// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
  				$this->set_error_class();
  				
  				$noerror = 0;
  			}
			
			}
				
		}
		return ($noerror);		
	}
	
	
}



?>
