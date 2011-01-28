<?php
include_once("cform_input.php");

class Cform_radio extends Cform_input 
{
	//Atributes
	var $m_disabled;
	var $m_tabindex;
	var $m_label;
	var $m_type;
	var $m_checked;
	var $m_value;
	var $m_button_array = array();
	var $m_mandatory;
	

	 /**
     * User Constructor
     * @param string $id
     * @param string $name  Input Name
	 * @param string $class Class Name
     * @param string $label Enter a string to show as a label
     * @param string $type	Enter the type of the label
     * @param string $minlenght	Enter the minlenght of the input (default: 0)
     * @param string $maxlenght	Enter the maxlenght of the input (default: 30)
     * @param string $size Enter the size of the input (default : 30)
     * @param string $value Enter the value of the input
     * @param boolean $disabled Make the input disabled
     * @param string $readonly Make the input readonly
     * @param int $tabindex	Number of tabindex
     * @param string $title_error Enter the title for validation 
     * @return void
     */
	function Cform_radio($id, $name, $class, $label = "",  $value = "", $mandatory = 0, $checked = false,  $disabled = false, $readonly = false,$tabindex =0)
	{
	 $this->m_disabled 	  = $disabled;
	 $this->m_readonly 	  = $readonly;
	 $this->m_tabindex 	  = $tabindex;
	 $this->m_label				= $label;
	 $this->m_type				= "radio";
	 $this->m_value				= $value;
	 $this->m_checked			= $checked;
	 $this->m_mandatory		= $mandatory;
//	 $this->add_button($value,$checked);

   Cform_radio::Cform_input($id,$name,$class, $label);
	}
	
	
	//Methods
	
	function get_disabled()
	{
		return $this->m_disabled;
	}
		
	
	function get_tabindex()
	{
		return  $this->m_tabindex;
	}
	
	
	function get_type()
	{
		return  $this->m_type;
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
	
	
	function set_to_checked($value)
	{
		if ($this->m_value == $value)
			$this->m_checked = true;
		else 
			$this->m_checked = false;
	}
	
	
	function set_to_unchecked($value)
	{
		$this->m_checked = false;
	}
	
	
	function get_value()
	{
		return  $this->m_value;
	}
	
	
	function get_button_array()
	{
		return $this->m_button_array;
	}
	
	
	function close_input()
	{
		if ($this->m_label != "")
		{
			$label_text = "<label for=\"".$this->m_id."\" id=\"lbf_".$this->m_id."\">".$this->m_label."</label>&nbsp;";
		}
		else
		{
			$label_text = "";
		}
		
		$close_input = "/> $label_text ";
		return $close_input;
	}
	
	
	/**
 * ADD RADIO BUTTON
 * 
 * @return string
 */
	function add_button($value, $checked=false)
	{
		if ( $checked == false )
		{
			$button = $value;
		}
		else
		{
			$button = $value.chr(9).$checked;
		}
		array_push($this->m_button_array,$button);
	}
	
	
	function add_input($attribute)
	{
		$input = $this->open_input()." ".$attribute."".$this->close_input();
		$this->m_input = $input;
	}
	
	
	/**
	 * MAKE RADIO BUTTON
	 * 
	 * @return string
	 */
	function display($return = false)
	{
    $radiobutton = " type=\"radio\" value=\"".$this->m_value."\" "; 
    
    if ( $this->m_disabled )
     $radiobutton .= $radiobutton ." disabled ";
    
    if ($this->m_checked )
     $radiobutton .= $radiobutton ." checked='checked' ";
     
    if ($this->m_tabindex != 0)
      $radiobutton = $radiobutton  . "tabindex =\"".$this->m_tabindex."\"";
    
    Cform_radio::add_input($radiobutton);
    
    if ($return)
  	  return $this->m_input."\n";
  	else 
  	  echo $this->m_input."\n";
	}
	
	
	
		/**
	* validate()
	* @return bool
	*/
	function validate()
	{
		$noerror = 1;
		
		if ($this->m_mandatory)
		{
			// Comprobamos que el campo sea numerico
			if (! is_numeric($this->m_value) )
			{					
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "radiobutton_numeric_not_numeric";
				$this->set_error_msg($error_msg);
				
				// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
				$this->set_error_class();
				
				$noerror = 0;
			}
		}

		return ($noerror);		
	}
}

?>
