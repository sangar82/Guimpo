<?php
include_once("cform_button.php");

class Cform_button_submit extends Cform_button 
{
	var $m_type ;
	
	//Constructor
	function Cform_button_submit($id, $name, $value, $class = '', $disabled = false , $tabindex = 0)
	{
		$this->m_type = "submit";
		
		Cform_button_submit::Cform_button($id,$name,$value,$class,$disabled,$tabindex);
	}
	

	//Methods
	function get_type()
	{
		return $this->m_type;
	}
	
	
	/**
	 * MAKE SUBMIT BUTTON
	 * 
	 * @return string
	 */
 function display($return = false)
	{
		$submit = "type=\"submit\" value =\"".$this->m_value ."\"";

		if ( $this->m_disabled )
		{
			$submit = $submit ." disabled =\"".$this->m_disabled."\"";
		}
		
		if ($this->m_tabindex != 0)
		  $submit = $submit  . "tabindex =\"".$this->m_tabindex."\"";
		
		Cform_button_submit::add_input($submit)."\n";
		
		if ($return)
		  return $this->m_input."\n";
		else 
		  echo $this->m_input."\n";
	}

	
	
	function validate()
	{
		return true;
	}
}

?>