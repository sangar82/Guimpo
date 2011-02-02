<?php

include_once('cform_text.php');
include_once('cform_button.php');
include_once('cform_button_submit.php');
include_once('cform_textarea.php');
include_once('cform_select.php');
include_once('cform_radio.php');
include_once('cform_checkbox.php');
include_once('cform_hidden.php');
include_once('cform_numeric.php');
include_once('cform_image.php');
include_once('cform_doc.php');
include_once('cform_datepicker.php');

/*
include_once('cform_label.php');

include_once('cform_textarea.php');


include_once('cform_input_password_field.php');
include_once('cform_input_file_field.php');
include_once('cform_input_file_field_image.php');
include_once('cform_input_file_field_image_multi.php');
include_once('cform_input_button_reset.php');
include_once('cform_input_text_field_username.php');
include_once('cform_input_text_field_numeric.php');
include_once('cform_input_text_field_digits.php');
include_once('cform_input_text_field_referencia.php');
include_once('cform_input_text_field_referencia_promocion.php');
include_once('cform_input_button_button_back.php');
include_once('cform_input_text_field_telefono.php');
include_once('cform_info.php');
include_once('cutils.php');
include_once('clanguage.php');
*/

class Cform
{
	//Atributes
	var $m_id;
	var $m_name;
	var $m_action;
	var $m_method;
	var $m_enctype;
	var $m_target;
 	var $m_label 		= array();
 	var $m_array_labels = array();
 	var $m_objects 	= array();
 	var $m_errors 	= array();
 	var $m_info			= array();
 	var $m_hasvalidation;
	
	
	function Cform($name = "", $id = "", $action = "", $method = "POST", $enctype = "multipart/form-data", $target = "_self", $hasvalidation = 0)
	{
		$this->m_name						= $name;
		$this->m_action					= $action;
		$this->m_method					= $method;
		$this->m_enctype				= $enctype;
		$this->m_target					= $target;
		$this->m_id 						= $id;
		$this->m_hasvalidation  = $hasvalidation;
	}
	
	
	function get_name()
	{
		return $this->m_name;
	}
	
	
	function get_id()
	{
		return $this->m_id;
	}
	
	
	function get_action()
	{
		return $this->m_action;
	}
	
	
	function get_method()
	{
		return $this->m_method;
	}
	
	
	function get_enctype()
	{
		return $this->m_enctype;
	}
	
	function get_objects()
	{
		return $this->m_objects;
	}
	
	
	function objects_separator()
	{
		return "<br><br>";
	}

	
	
	/**
	 * add_label
	 * 
	 * @return nothing ( only puts a new label (as input, select, textarea, button, label, fieldset) into the array of labels )
	 */
	function add_label($label, $name_label = '')
	{
		if (!$name_label)
			array_push($this->m_array_labels,$label);
		else 
			$this->m_array_labels[$name_label] = $label;
	}
	
	
	/**
	 * add_inputs
	 * 
	 * @return nothing ( only puts a new label (as input, select, textarea, button, label, fieldset) into the array of labels )
	 */
	function add_inputs($input, $name_input = '')
	{
		if (!$name_input)
			array_push($this->m_objects,$input);
		else 
			$this->m_objects[$name_input] = $input;
	}
	
	
	/**
	* add_errors
	* 
	* @return nothing ( add a new error at the errors array )
	*/	
	function add_error($field_name, $message_error)
	{
		$this->m_errors[$field_name] = $message_error;
	}
	
	
	/**
	 * get_array_errors
	 * 
	 * @return array Returns the errors array
	 */
	function get_array_errors()
	{
		return $this->m_errors;
	}
	
	 /**
	 * get_array_errors
	 * 
	 * @return array Returns the errors array
	 */
	function display_array_errors()
	{
		$string_errors = "";
		
		$lng = Cutils::get_filtered_lng();
		
		$language = new Clanguage($lng);
		
		foreach ($this->m_errors as $key => $error)
		{
			$string_errors .= $language->get_element_generic($error)."<br />";
		}
		
		return  $string_errors;
	}
	
	
	
	/**
	* open_form_errors
	* 
	* @return string Open a form errors section
	*/
	function open_form_errors()
	{
		$open_form_errors = "<div id='form_errors'>";
		return $open_form_errors;
	}
	
	
	/**
	* close_form_errors
	* 
	* @return string Close a form errors section
	*/	
	function close_form_errors()
	{
		$close_form_errors = "</div>";
		return $close_form_errors;
	}

	
	/**
	 * OPEN FORM
	 * 
	 * @return A string which contents is the open form label <form> with their attributes
	 */
	function open_form()
	{
	 	$open_form = "<form id=\"".$this->m_id."\" class=\"formsweb\" action=\"".$this->m_action."\" method=\"".$this->m_method."\" enctype=\"".$this->m_enctype."\" name=\"".$this->m_name."\" target=\"".$this->m_target."\" >\n";
		return $open_form;
	}
	
	
		/**
	 * close_form
	 * 
	 * @return </form>
	 */
	function close_form()
	{
		$close_form = "</form>\n";
		return $close_form;
	}
	
	
	/**
	* add_scripts_validation
	* 
	* @return void Echo
	*/
	function add_scripts_validation()
	{
		echo "<script src='../js/jquery.js' type='text/javascript'></script>";
		echo "<script src='../js/jquery.validate.js' type='text/javascript'></script>";
		echo "<script>";
  			echo "$(document).ready(function(){";
    			echo "$(\"#$this->m_name\").validate();";
  			echo "});";
  		echo "</script>";
	}
	
	
	/**
	 * DISPLAY
	 * 
	 * @return writes the final form
	 */
	function display()
	{
		  echo $this->open_form_errors();
		  echo $this->display_array_errors();
		  echo $this->close_form_errors();
		  
			echo $this->open_form()."\n";
			//foreach ($this->m_label as $label => $label_value)
			//{
				//$label_value->display();
			//}
			foreach ($this->m_objects as $objects => $objects_value)
			{
				$objects_value->display();
			}
			echo $this->close_form()."\n";
	}
	
	
	function display_open_form()
	{
		echo $this->open_form_errors()."\n";
	  echo $this->display_array_errors()."\n";
	  echo $this->close_form_errors()."\n";
	  
		echo $this->open_form()."\n";
	}
	
	
	function display_close_form()
	{
		echo $this->close_form()."\n";
	}
	
	

}

?>
