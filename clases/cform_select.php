<?php

//include_once('clanguage.php');

class Cform_select
{
	//Atributes
	var $m_name;
	var $m_id;
	var $m_class;
	var $m_label;
	var $m_type;
	var $m_mandatory;
	var $m_size;
	var $m_multiple;
	var $m_disabled;
	var $m_tabindex;
	var $m_array_options;
	var $m_lang_actual;
	var $m_language;
	var $m_with_language;
	var $m_with_default_value;
	var $m_value;
	
	//Constructor
	function Cform_select($id = "", $name = "", $class = "", $label = "", $mandatory = 0, $with_language = 0, $with_default_value = 1,  $lng = 'es',  $size = 1, $multiple = false, $disabled = false, $tabindex = 0)
	{
		$this->m_name 							= $name;
		$this->m_id 								= $id;
		$this->m_class 							= $class;
		$this->m_label 							= $label;
		$this->m_type								= "select";
		$this->m_mandatory					= $mandatory;
		$this->m_size 							= $size;
		$this->m_multiple 					= $multiple;
		$this->m_disabled 					= $disabled;
		$this->m_tabindex 					= $tabindex;
		$this->m_lang_actual				= $lng;
		$this->m_with_language			= $with_language;
		$this->m_with_default_value = $with_default_value;
		$this->m_array_options  		= array();
		
		
		// Si necesita recoger valores del archivo de idiomas cargamos el objeto idioma para acceder a ellos
		if ($this->m_with_language)
		{
			//creamos el objeto
			$this->m_language = new Clanguage($this->m_lang_actual);
		}
		
		// Añadimos el valor por defecto si se desea
		if ($this->m_with_default_value)
		{
			//Creamos el objeto por defecto
			$this->add_option('', 'Selecciona...', true);
		}
		
		//Add class for javascript validation
		if ($this->m_mandatory)
			$this->add_class("required");
	}

	//Methods
	function get_name()
	{
		return $this->m_name;
	}
	
	
	function get_id()
	{
		return $this->m_id;
	}

	
	function get_class()
	{
		return $this->m_class;
	}
	
	
	function get_size()
	{
		return $this->m_size;
	}
	
	
	function get_value()
	{
		return $this->m_value;
	}
	
	
	function get_type()
	{
		return $this->m_type;
	}
	
	
	function get_multiple()
	{
		return $this->m_multiple;
	}
	
	
	function get_disabled()
	{
		return $this->m_disabled;
	}
	
	
	function get_tabindex()
	{
		return $this->m_tabindex;
	}
	
	
	function get_array_options()
	{
		return $this->m_array_options;
	}
	
	
	function get_lang_actual()
	{
		return $this->m_lang_actual;
	}
	
	
	function get_has_lang()
	{
		if ($this->m_with_language)
			return true;
		else 
			return false;
	}
	
	
	function get_language()
	{
		return $this->m_language;
	}
	
	
	function set_value($value)
	{
		$this->m_value = $value;
	}
	
	
	function set_to_selected($value)
	{
		foreach ($this->m_array_options as $key => $option)
		{
			if ($option['value'] == $value)
			{
				$this->m_array_options[$key]['selected'] = true;
			}
			else
			{
				$this->m_array_options[$key]['selected'] = false;				
			}
		}
	}
	
	
	function add_class($class)
	{
		$this->m_class = $this->m_class . " " . $class;
	}
	
	
	function set_error_class()
	{
		$this->m_class = $this->m_class ." input_error";
	}
	

	function get_error_msg()
	{
		return $this->m_error_msg;
	}
	
	
	function set_error_msg($msg)
	{
		$this->m_error_msg = $msg;
	}
	
	
	/**
	 * ADD OPTION
	 * 
	 * @return nothing, only add and option into label select
	 */
	function add_option($value,$text,$selected=false)
	{
		if ($this->get_has_lang())
		{
			$options_field = array("value"=>$value, "text"=> $this->get_language()->get_element_generic($text), "selected"=> $selected);
		}
		else
		{
			$options_field = array("value"=>$value, "text"=>$text, "selected"=> $selected);
		}		
		
		array_push($this->m_array_options,$options_field);
	}
	
	
	/**
	 * ADD OPTION without language
	 * 
	 * @return nothing, only add and option into label select without a translatin
	 */
	function add_option_without_languages($value,$text,$selected=false)
	{
		$options_field = array("value"=>$value, "text"=>$text, "selected"=> $selected);
		array_push($this->m_array_options,$options_field);
	}	
	
	
	
	
	/**
	 * ADD OPTION
	 * 
	 * @return nothing, only add and option into label select
	 */
	function add_option_from_bd($table_name = '',$column_index = '' , $column_name = '', $query_options = '', $default = '' )
	{
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
		$query = "SELECT $column_index, $column_name FROM $table_name $query_options";
		
		$column = $con->fetch_array($query);
		
		foreach ($column as $col)
		{
			if ($default == $col[$column_index])
				$def = true;
			else
				$def = false;
				
			if ($this->get_has_lang())
			{
				if (is_numeric($col[$column_name]))
				{
					$options_field = array("value"=>$col[$column_index], "text"=> $col[$column_name], "selected"=> $def);
				}
				else
				{
					$options_field = array("value"=>$col[$column_index], "text"=> $this->get_language()->get_element_generic($col[$column_name]) , "selected"=> $def);
				}
			}
			else
				$options_field = array("value"=>$col[$column_index], "text"=> $col[$column_name], "selected"=> $def);
			
				array_push($this->m_array_options,$options_field);
		}	
	}

	
		/**
	 * OPEN SELECT
	 * 
	 * @return string
	 */
	function open_select()
	{
		$select = "<select id=\"".$this->m_id."\" name=\"".$this->m_name."\" class=\"".$this->m_class."\" size=\"".$this->m_size."\" ";
		if ( $this->m_disabled == true )
		{
			$select .= " disabled ";
		}
		if ( $this->m_size != 1 and $this->m_multiple == true )
		{
			$select .= " multiple ";
		}
		
		if ($this->m_tabindex){
		  $select .= " tabindex=\"".$this->m_tabindex."\" ";
		}
		
		$select .= ">";
		return $select;
	}
	
	
		/**
	 * CLOSE SELECT
	 * 
	 * @return string
	 */
	function close_select()
	{
		$select = "</select>";
		return $select;
	}
	
	
	/**
	*  DRAW A SELECTED LABEL
	*
	* @return label selected
	*/
	
	function display($return = false)
	{
		$select = $this->open_select()."\n";
		foreach ($this->m_array_options as $options )
		{
				$selected = ($options['selected'] == true ) ? "selected" : "";
				
				$select .= "<option value=\"".$options['value']."\" $selected >".$options['text']."</option> \n";
		}
		$select .= $this->close_select()."\n";
		
		if ($return)
  	  return $select."\n";
  	else 
  	  echo $select."\n";
  	  
	}
	
	/**
	*  RETURN A SELECTED LABEL
	*
	* @return label selected
	*/	
	function rdisplay()
	{
		$select = $this->open_select()."\n";
		foreach ($this->m_array_options as $options )
		{
				$selected = ($options['selected'] == true ) ? "selected" : "";
				
				$select .= "<option value=\"".$options['value']."\" $selected >".$options['text']."</option> \n";
		}
		$select .= $this->close_select()."\n";
		return $select;
	}
	
	
	function validate()
	{
		$noerror = 1;
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory)
		{
			// Si es obligatorio miramos que no sea nulo
			if ($this->m_value == "")
			{
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "must_select_a_value";
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
