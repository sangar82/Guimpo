<?php
include_once("cform_text.php");

class Cform_file extends Cform_text
{
	//Constructor
	function Cform_file($id, $name, $class = '' , $label = '', $value = '', $mandatory = 0, $type = "file", $minlenght = 5, $maxlenght = 100, $size = 30){
		Cform_file::Cform_text($id, $name, $class, $label, $value, $mandatory, "file", $minlenght, $maxlenght, $size);
		
		$this->m_type = $type;
	}
	
	
	/**
	 * Return the file extension
	 * 
	 * @return string
	 */
	function get_file_extension($filename){
		return strtolower(end(explode(".", $filename)));
	}
}

?>