<?php
class Cform_input
{
	//Atributes
	var $m_id;
	var $m_name;
	var $m_class;
	var $m_input;
	var $m_label;
	var $m_mandatory;
	var $m_error_msg;


	//Constructor
	function Cform_input($id = "", $name = "", $class = "", $label="", $mandatory = 0)
	{
		$this->m_name				= $name;
		$this->m_id					= $id;
		$this->m_class			= $class;
		$this->m_label			= $label;
		$this->m_mandatory	= $mandatory;
		$this->m_error_msg 	= "";
		
		//Add class for javascript validation
		if ($this->m_mandatory)
			$this->add_class("required");
			
	}


	//Methods
	function get_id()
	{
		return $this->m_id;
	}

	
	function get_name()
	{
		return $this->m_name;
	}

	
	function get_class()
	{
		return  $this->m_class;
	}
	
	
	function get_mandatory()
	{
		return $this->m_mandatory;
	}
	
	
	function get_input()
	{
		return  $this->m_input;
	}

	
	function set_label($label)
	{
		$this->m_label = $label;
	}

	
	function get_error_msg()
	{
		return $this->m_error_msg;
	}
	
	
	function set_error_msg($msg)
	{
		$this->m_error_msg = $msg;
	}
	
	
	function add_class($class)
	{
		$this->m_class = $this->m_class . " " . $class;
	}
	
	
	function set_error_class()
	{
		$this->m_class = $this->m_class . " input_error";
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
		$close_input = "/>";
		return $close_input;
	}

	
	/**
	 * MAKE INPUT LABEL
	 * 
	 * @return string
	 */
	function  add_input($attribute)
	{
		$input = $this->open_input()." ".$attribute." ".$this->close_input();
		$this->m_input = $input;
	}
}
?>