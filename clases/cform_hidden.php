<?php
include_once("cform_input.php");

class Cform_hidden extends Cform_input 
{
	//Atributes
	var $m_type;
	var $m_value;
	var $m_maxlenght;
	var $m_mandatory;
	
	//Constructor
	function Cform_hidden($id, $name, $class = "", $label = "",  $value = "", $maxlenght = 50, $mandatory = 1)
	{
	 	$this->m_value 			   	= $value;
	 	$this->m_type				    = "hidden";
	 	$this->m_maxlenght			= $maxlenght;
	 	$this->m_mandatory			= $mandatory;
	 	
	 	Cform_hidden::Cform_input($id,$name,$class,  $label, $mandatory);
	}
	
	//Methods
	function get_type(){
		return $this->m_type;
	}

	
	function get_value(){
		return $this->m_value;
	}
	
	
	function set_value($value){
		$this->m_value = $value;
	}
	
	
	function set_error_class(){
		$this->m_class = $this->m_class ." input_error";
	}
	
	
	/**
	 * MAKE HIDDEN FIELD 
	 * 
	 * @return string
	 */
	function display($return = false){
		$hidden = " type=\"hidden\" value=\"".$this->m_value."\""; 
	
		Cform_hidden::add_input($hidden);
		
		if ($return)
		  return $this->m_input."\n";
		else 
		  echo $this->m_input."\n";
	}
	
	
	function rdisplay(){
		$hidden = " type=\"hidden\" value=\"".$this->m_value."\""; 
	
		Cform_hidden::add_input($hidden);
		return $this->m_input;
	}
	
	
	function validate(){
		$noerror = 1;
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory)
		{
			// Si es obligatorio miramos que no sea nulo
			if ($this->m_value != "")
			{
				// Miramos la largada del "value" del objeto
				$len=strlen($this->m_value);
				
				// Comparamos con los valores maximos y minimos definidos al crear el objeto
				if ($len > $this->m_maxlenght or $len < 1)
				{
					// Asignamos al atributo error_msg el mensaje de error
					$error_msg = "text_field_string_range_not_valid";
					$this->set_error_msg($error_msg);
					
					$noerror = 0;
				}
			}
			else
			{
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "text_field_null";
				$this->set_error_msg($error_msg);
				
				$noerror = 0;
			}		
		}
		return ($noerror);		
	}
}

?>
