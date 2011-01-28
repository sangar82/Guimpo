<?php
include_once("cform_file.php");

class Cform_image extends Cform_file
{
	//Constructor
	function Cform_image($id, $name, $class = '', $label = '', $value = '', $mandatory = 0, $type = 'file', $minlenght = 5, $maxlenght = 100, $size = 30)
	{
		Cform_image::Cform_file($id, $name, $class, $label, $value, $mandatory, "file", $minlenght, $maxlenght, $size);
		
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

				if ($this->get_file_extension($name) != "jpg" and $this->get_file_extension($name) != "jpeg" and $this->get_file_extension($name) != "gif" and $this->get_file_extension($name) != "png")
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
			
  			if ($this->get_file_extension($name) != "jpg" and $this->get_file_extension($name) != "jpeg" and $this->get_file_extension($name) != "gif" and $this->get_file_extension($name) != "png"){
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
