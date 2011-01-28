<?php
class Cform_textarea
{
	//Atributes
	var $m_name;
	var $m_id;
	var $m_class;
	var $m_label;
	var $m_type;
	var $m_mandatory;
  var $m_rows;
	var $m_cols;
	var $m_wrap;
	var $m_value;
	var $m_disabled;
	var $m_readonly;
	var $m_tabindex;
	var $m_minlenght;
	var $m_maxlenght;
	
	//Constructor
	function Cform_textarea($id = '', $name = '', $class = '', $label = '',  $value = '', $mandatory = 0, $cols = 57, $minlength = 2, $maxlength = 256,  $rows = 8,  $wrap = 'VIRTUAL', $disabled = false, $readonly = false, $tabindex = 0 )
	{
		$this->m_name 		 	 = $name;
		$this->m_id 		 	 	 = $id;
		$this->m_class 		 	 = $class;
		$this->m_label 		 	 = $label;
		$this->m_type				 = "textarea";
		$this->m_mandatory	 = $mandatory;
		$this->m_rows 		 	 = $rows ;
		$this->m_cols 		 	 = $cols;
		$this->m_wrap 		 	 = $wrap;
		$this->m_value 	 	 	 = $value;
		$this->m_disabled 	 = $disabled;
		$this->m_readonly 	 = $readonly;
		$this->m_tabindex 	 = $tabindex;
		$this->m_minlenght 	 = $minlength;
		$this->m_maxlenght	 = $maxlength;
		
		
		//Add class for javascript validation
		if ($this->m_mandatory)
			$this->add_class("required");
	}
	
	
	//Methods
 	function get_id(){
		return $this->m_id;
	}
	
	
	function get_name(){
		return $this->m_name;
	}
	
	
	function get_class(){
		return  $this->m_class;
	}
	
	
	function get_rows(){
		return $this->m_rows;
	}
	
	
	function get_cols(){
		return  $this->m_cols;
	}
	
	
	function get_disabled(){
		return $this->m_disabled;
	}
	
	
	function get_readonly(){
		return $this->m_readonly;
	}
	
	
	function get_tabindex(){
		return  $this->m_tabindex;
	}
	
	
	function get_wrap(){
		return  $this->m_wrap;
	}
	
	
	function get_value(){
		return $this->m_value;
	}
	
	
	function set_value($value){
		$this->m_value = $value;
	}
	
	
	function add_class($class){
		$this->m_class = $this->m_class . " " . $class;
	}
	
	
	function get_type(){
		return $this->m_type;
	}
	
	
	function set_error_class(){
		$this->m_class = $this->m_class ." input_error";
	}
	
	
	function get_error_msg(){
		return $this->m_error_msg;
	}
	
	
	function set_error_msg($msg){
		$this->m_error_msg = $msg;
	}

		/**
	 * OPEN TEXTAREA
	 * 
	 * @return string
	 */
	function open_textarea()
	{
		$open_textarea = "<textarea name=\"".$this->m_name."\" id=\"".$this->m_id."\" rows=\"".$this->m_rows."\" cols=\"".$this->m_cols."\" "; 
		
		if ( $this->m_class != ""){
			$open_textarea .= " class=\"".$this->m_class."\"";
		}
		
		if ( $this->m_disabled ){
			$open_textarea .= " disabled=\"".$this->m_disabled."\"";
		}
		
		if ( $this->m_readonly ){
			$open_textarea .= " readonly=\"".$this->m_readonly."\"";
		}
		
		if ($this->m_minlenght){
			$open_textarea .= " minlength=\"".$this->m_minlenght."\"";
		}
		
		if ($this->m_maxlenght){
			$open_textarea .= " maxlength=\"".$this->m_maxlenght."\"";
		}
		
		if ($this->m_tabindex){
		  $open_textarea .= " tabindex=\"".$this->m_tabindex."\" ";
		}
		
		if ($this->m_wrap){
		  $open_textarea .= " wrap=\"".$this->m_wrap."\" ";
		}
		
		$open_textarea .= ">";

		return $open_textarea;
	}
	
	/**
	 * CLOSE	TEXTAREA
	 * 
	 * @return string
	 */
	function close_textarea(){
		$close_textarea = "</textarea>\n";
		return $close_textarea;
	}

	function display($return = false){
    $textarea = $this->open_textarea()."".$this->m_value."".$this->close_textarea();
		
    if ($return)
		  return $textarea."\n";
		else 
		  echo $textarea."\n";
	}
	
	function rdisplay(){
  $textarea = $this->open_textarea()."".$this->m_value."".$this->close_textarea();
		return $textarea;
	}
	
	
	/**
	* validate()
	* @return bool
	*/
	function validate(){
		$noerror = 1;
		
		// Miramos si el campo es obligatorio
		if ($this->m_mandatory){
		  
			// Si es obligatorio miramos que no sea nulo
			if ($this->m_value != ""){
				// Miramos la largada del "value" del objeto
				$len=strlen($this->m_value);
				
				// Comparamos con los valores maximos y minimos definidos al crear el objeto
				if ($len >  3 * $this->m_maxlenght or $len < $this->m_minlenght){
					// Asignamos al atributo error_msg el mensaje de error
					$error_msg = "text_field_string_range_not_valid";
					$this->set_error_msg($error_msg);
					
					// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
					$this->set_error_class();
					
					$noerror = 0;
				}
			}else{
				// Asignamos al atributo error_msg el mensaje de error
				$error_msg = "text_field_null";
				$this->set_error_msg($error_msg);
				
				// Añadimos al input la clase de error para que se muestre por pantalla (.input_error)
				$this->set_error_class();
				
				$noerror = 0;
			}			
		}else{
			$len=strlen($this->m_value);
			
			//si no se ha introducido nada no hay error ya que no es obligatorio (mandatory)
			if ($len){
				if ($len > 3 * $this->m_maxlenght or $len < $this->m_minlenght){
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
