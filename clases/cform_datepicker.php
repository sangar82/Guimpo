<?php

include_once("cform_input.php");

class Cform_datepicker extends Cform_input 
{
	//Atributes
	var $m_minlenght;
	var $m_maxlenght;
	var $m_size;
	var $m_value;
	var $m_disabled;
	var $m_readonly;
	var $m_tabindex;
	var $m_title_error;
	var $m_type;
	var $m_autocomplete;
	
	
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
	function Cform_datepicker($id, $name, $class = '', $label = '', $value = '',  $mandatory = 0, $type="datepicker", $minlenght= "", $maxlenght = 60, $size = 60, $disabled = false, $readonly = false, $tabindex = 0, $autocomplete='')
	{
		$this->m_minlenght 		= $minlenght;
		$this->m_maxlenght 		= $maxlenght;
		$this->m_size 				= $size;
		$this->m_value 		     = $value;
		$this->m_disabled 		= $disabled;
		$this->m_readonly 		= $readonly;
		$this->m_tabindex 		= $tabindex;
		$this->m_type 		     = 'datepicker';
		$this->m_autocomplete	= $autocomplete;
		
		Cform_datepicker::Cform_input($id, $name, $class, $label, $mandatory);
	}
	
	
	//Methods
	function get_type()
	{
		return $this->m_type;
	}
	
	
	function get_maxlenght()
	{
		return $this->m_maxlenght;
	}
	
	
	function get_minlenght()
	{
		return $this->m_minlenght;
	}
	
	
	function get_size()
	{
		return  $this->m_size;
	}
	
	
	function get_value()
	{
		return $this->m_value;
	}
	
	
	function set_value($value)
	{
		$this->m_value = $value;
	}
	
	
	function get_disabled()
	{
		return $this->m_disabled;
	}
	
	
	function get_readonly()
	{
		return $this->m_readonly;
	}
	
	
	function get_tabindex()
	{
		return  $this->m_tabindex;
	}
	
	
	function get_alt()
	{
		return  $this->m_alt;
	}

	
	/*
	* MAKE FIELD TEXT
	* 
	* @return string
	*/
	function display( $return = false )
	{
		$text = "type=\"".$this->m_type."\" maxlength=\"".$this->m_maxlenght."\" size=\"".$this->m_size."\""; 
		
		if ( $this->m_value != "" )
			$text = $text ." value=\"".$this->m_value."\"";
		
		if ( $this->m_disabled )
			$text = $text ." disabled=\"".$this->m_disabled."\"";
		
		if ( $this->m_readonly )
			$text = $text ." readonly=\"".$this->m_readonly."\"";
		
		if ($this->m_minlenght)
			$text = $text ." minlength=\"".$this->m_minlenght."\"";
		
		if ($this->m_title_error)
			$text = $text . " title=\"".$this->m_title_error."\"";
		
		if ($this->m_autocomplete == 'on')
			$text = $text . " autocomplete='on'";
		else if ($this->m_autocomplete == 'off')
			$text = $text . " autocomplete='off'";
		
		if ($this->m_tabindex != 0)
		  $text = $text  . "tabindex =\"".$this->m_tabindex."\"";
		
		Cform_text::add_input($text);
		
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
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory)
		{
			// Si es obligatorio miramos que no sea nulo
			if ($this->m_value != "")
			{
				// Miramos la largada del "value" del objeto
				$len=strlen($this->m_value);
				
				// Comparamos con los valores maximos y minimos definidos al crear el objeto
				if ($len > 3 * $this->m_maxlenght or $len < $this->m_minlenght)
				{
					// Asignamos al atributo error_msg el mensaje de error
					$error_msg = "text_field_string_range_not_valid";
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
			$len=strlen($this->m_value);
			
			//si no se ha introducido nada no hay error ya que no es obligatorio (mandatory)
			if ($len)
			{
				if ($len > 3 * $this->m_maxlenght or $len < $this->m_minlenght)
				{
					// Asignamos al atributo error_msg el mensaje de error
					$error_msg = "text_field_string_range_not_valid";
          
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
