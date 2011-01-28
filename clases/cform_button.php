<?php
include_once("cform_input.php");

class Cform_button extends Cform_input 
{
	//Atributes
	var $m_value;
	var $m_disabled;
	var $m_tabindex;
	
	//Constructor
	function Cform_button($id, $name,  $value = '', $class = '', $disabled = false, $tabindex = 0)
	{
	 
	 $this->m_value = $value;
	 $this->m_disabled = $disabled;
	 $this->m_tabindex = $tabindex;
	 
	 Cform_button::Cform_input($id,$name,$class);
	}
	
	
	//Methods
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

	function get_tabindex()
	{
		return  $this->m_tabindex;
	}
}

?>