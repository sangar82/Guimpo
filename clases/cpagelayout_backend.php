<?php

require_once('clocation.php');
require_once('cpagebase.php');

class Cpagelayout_backend extends Cpagebase {	
  
	//path helpers
	var $m_include_folder;
	var $m_include_view;
	var $m_layout;
	
	//sections
	var $m_top;
	var $m_menu;
	var $m_main;
	var $m_laterald;
	var $m_footer;
	
	private $m_location;
	
	
	function Cpagelayout_backend( $section_names )
	{
		$this->m_include_folder 	= "backend";
		$this->m_layout						= "backend";
		//$this->m_include_view 		= $section_names['main'].".php";
		
		$this->m_top 			= $section_names['top'];
		$this->m_menu 		= $section_names['menu'];
		$this->m_main 		= $section_names['main'];
		$this->m_footer 	= $section_names['footer'];
		
		//insertamos estilos por defecto
		$this->add_styles(PATH_ROOT_CSS. 'styles.css');
				
		Cpagelayout_backend::Cpagebase();
		
		//Creamos el objeto de lenguage
		$this->m_language = new Clanguage(ADMIN_LANGUAGE);
	
		//asignamos el valor del lenguaje actual
		$this->m_actual_language = ADMIN_LANGUAGE; 		
		
		//Hacemos que el backend este protegido por sesión
		$this->get_session()->check();

		//Creamos el objeto clocation
		$this->m_location = new Clocation($this->get_language()->get_language(),"frontend");
	}
	
	
	function set_page_layout($layout){
	  
	  $this->m_layout = $layout;
	  
	}
	
	
	function display(){
		Cpagebase::display_members();
			$this->include_start_body();
			$this->include_layouts();
			$this->include_end_body();
		Cpagebase::close_page();	
	}
	
	
	function getTop(){
		return ($this->m_top);
	}
	
	
	function get_location(){
		return $this->m_location;
	}
	
	
	function getMenu(){
		return ($this->m_menu);
	}
	
	
	function getMain(){
		return ($this->m_main);
	}
	
	
	function getFooter(){
		return($this->m_footer);
	}
	
	
	function include_views($section, $view){
		 require_once(PATH_ROOT . 'vistas/'.$this->m_include_folder.'/'.$section.'/'.$view.'.php');
	}
	
	
	function include_layouts(){
		 require_once(PATH_ROOT . 'layouts/'.$this->m_include_folder.'/'.$this->m_layout.'.php');		
	}
	
	
	function include_start_body(){
		echo "<body>\n";
	}
	
	
	function include_end_body(){
		echo $this->get_google_analytics_code();
		echo "</body>\n";
	}
	
	
	function get_google_analytics_code(){
	  
    if (ENVIRONMENT == 'production' )
  	  $code = '';
  	else 
  	  $code = '';
  
  	return $code;
	}	
	
}

?>
