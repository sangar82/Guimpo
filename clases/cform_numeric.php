<?php
include_once("cform_text.php");

class Cform_numeric extends Cform_text
{
	
	/**
	* User Constructor
	* @param string $id
	* @param string $name  Input Name
	* @param string $class Class Name
	* @param string $label Enter a string to show as a label
	* @param string $value Enter the value of the input
	* @param bool $mandatory Make the input mandatory
	* @param string $type	Enter the type of the label
	* @param string $minlenght	Enter the minlenght of the input (default: 0)
	* @param string $maxlenght	Enter the maxlenght of the input (default: 30)
	* @param string $size Enter the size of the input (default : 30)
	* @param boolean $disabled Make the input disabled
	* @param string $readonly Make the input readonly
	* @param int $tabindex	Number of tabindex
	* @param string autocomplete on/off
	* @return void
	*/
	function Cform_numeric($id, $name, $class, $label = "", $value = "", $mandatory = 0, $type = "text",$minlenght = 0, $maxlenght = 60, $size = 60, $disabled = false, $readonly = false, $tabindex = 0,  $autocomplete = "")
	{
		Cform_numeric::Cform_text($id, $name, $class, $label, $value, $mandatory, "text", $minlenght, $maxlenght, $size, $disabled, $readonly, $tabindex, $autocomplete);
	
		//Add class for javascript validation
		$this->add_class("number");
	}
	
	
	function display( $return = false )
	{
		$text = " type =\"".$this->m_type."\" max =\"".$this->m_maxlenght."\" size =\"".$this->m_size."\" value =\"".$this->m_value."\" tabindex =\"".$this->m_tabindex."\""; 
		
		if ( $this->m_disabled ){
			$text = $text ." disabled =\"".$this->m_disabled."\"";
		}
		
		if ( $this->m_readonly ){
			$text = $text ." readonly =\"".$this->m_readonly."\"";
		}
		
		if ($this->m_minlenght){
			$text = $text ." min =\"".$this->m_minlenght."\"";
		}
		
		if ($this->m_autocomplete == 'on')
			$text = $text . " autocomplete='on'";
		else if ($this->m_autocomplete == 'off')
			$text = $text . " autocomplete='off'";
		
		Cform_text::add_input($text);
		
		if ($return)
		  return $this->m_input."\n";
		else 
		  echo $this->m_input."\n";
	}
	
	
	function rdisplay()
	{
		$text = " type =\"".$this->m_type."\" max =\"".$this->m_maxlenght."\" size =\"".$this->m_size."\" value =\"".$this->m_value."\" tabindex =\"".$this->m_tabindex."\""; 
		if ( $this->m_disabled )
		{
			$text = $text ." disabled =\"".$this->m_disabled."\"";
		}
		if ( $this->m_readonly )
		{
			$text = $text ." readonly =\"".$this->m_readonly."\"";
		}
		if ($this->m_minlenght)
		{
			$text = $text ." min =\"".$this->m_minlenght."\"";
		}
		if ($this->m_title_error)
		{
			$text = $text . " title=\"".$this->m_title_error."\"";
		}
		
		Cform_text::add_input($text);
		return $this->m_input;
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
				// Comprobamos que el campo sea numerico
				if ( is_numeric($this->m_value) )
				{
					// Miramos la largada del "value" del objeto
					$len=strlen($this->m_value);
					
					// Comparamos con los valores maximos y minimos definidos al crear el objeto
					if ($len > $this->m_maxlenght or $len < $this->m_minlenght)
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
					$error_msg = "text_field_numeric_not_numeric";
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
		// no es mandatory
		else 
		{
			$len=strlen($this->m_value);
			
			//si no se ha introducido nada no hay error ya que no es obligatorio (mandatory)
			if ($len)
			{
					// Comprobamos que el campo sea numerico
					if (! is_numeric($this->m_value) )
					{					
						// Asignamos al atributo error_msg el mensaje de error
						$error_msg = "text_field_numeric_not_numeric";
						$this->set_error_msg($error_msg);
						
						// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
						$this->set_error_class();
						
						$noerror = 0;
					}
					else
					{
						if ($len > $this->m_maxlenght or $len < $this->m_minlenght)
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
		}
		return ($noerror);		
	}
	
	
	
}

?>
