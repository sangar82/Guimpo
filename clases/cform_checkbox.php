<?php
include_once("cform_input.php");

class Cform_checkbox extends Cform_input 
{
	//Atributes
	var $m_value;
	var $m_checked;
	var $m_disabled;
	var $m_tabindex;
	var $m_type;
	var $m_array_check = array();
	
	//Constructor
	function Cform_checkbox($id, $name, $class, $label = "", $value = "", $checked = false, $mandatory = 0, $disabled = false, $readonly = false, $tabindex = 0)
	{
		$this->m_type				 = "checkbox";
		$this->m_label 		   = $label;
		$this->m_checked		 = $checked;
		$this->m_disabled 	 = $disabled;
		$this->m_readonly 	 = $readonly;
		$this->m_tabindex 	 = $tabindex;
		$this->m_value 			 = $value;
		
		Cform_checkbox::Cform_input($id,$name,$class, $label, $mandatory);

		//Add class for javascript validation
		if ($this->m_mandatory)
			$this->add_class("required");
	}
	
	
	//Methods
	function get_type()
	{
		return $this->m_type;
	}
	
	
	function get_disabled()
	{
		return $this->m_disabled;
	}
		
	
	function get_tabindex()
	{
		return  $this->m_tabindex;
	}
	
	
	function get_array_check()
	{
		return $this->m_array_check;
	}
	
	
	function set_value($value)
	{
		$this->m_value = $value;
	}
	
	
	function is_checked()
	{
		if ($this->m_checked)
			return true;
		else 
			return false;
	}
	
	
	function set_to_checked()
	{
		$this->m_checked = true;
	}
	
	
	function set_to_unckecked()
	{
		$this->m_checked = false;
	}
	
	
	function get_value()
	{
		return $this->m_value;
	}
	
	
	/**
 * ADD CHECKBOX
 * 
 * @return string
 */
	function add_check($value, $checked=false)
	{
		if ( $checked == false )
		{
			$button = $value;
		}
		else
		{
			$button = $value. chr(9) .$checked;
		}
		array_push($this->m_array_check,$button);
	}

	/**
	 * MAKE A CHECKBOX
	 * 
	 * @return string
	 */
	function display( $return = false){
	  
  	$checkbox = " type=\"checkbox\" value=\"".$this->m_value."\" class=\"$this->m_class\""; 
  	
  	if ($this->m_checked)
  		$checkbox .= " checked ";
  	
  	if ( $this->m_disabled )
  		$checkbox .= " disabled ";
  	
  	if ($this->m_tabindex != 0)
      $checkbox .= $checkbox  . "tabindex =\"".$this->m_tabindex."\"";
  	
  	Cform_checkbox::add_input($checkbox);
  	
   	if ($return)
  	  return $this->m_input."\n";
  	else 
  	  echo $this->m_input."\n";
  		  
	}
	
		/**
	 * OPEN INPUT
	 * 
	 * @return string
	 */
	function open_input()
	{
		$open_input = "<input id=\"".$this->m_id."\" name=\"".$this->m_name."\"";
		if ( $this->m_class != "")
		{
			$open_input .= " class=\"".$this->m_class."\"";
		}
		
		return $open_input;
	}
	
		/**
	 * CLOSE	INPUT
	 * 
	 * @return string
	 */
	function close_input()
	{
		if ($this->m_label != "")
		{
			$label_text = "<label for=\"".$this->m_id."\">".$this->m_label."</label>&nbsp;";
		}
		else
		{
			$label_text = "";
		}
		
		$close_input = "> $label_text ";
		return $close_input;
	}
	
	function add_input($attribute)
	{
		$input = $this->open_input()." ".$attribute." ".$this->close_input();
		$this->m_input = $input."\n";
	}
	
	
	function validate()
	{
		$noerror = 1;
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory)
		{
			// Si es obligatorio miramos que no sea nulo
			if ($this->m_checked == false)
			{
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "must_checked";
				$this->set_error_msg($error_msg);
				
				// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
				$this->set_error_class();
				
				$noerror = 0;
			}
		}
		return $noerror;
	}
}

?>
