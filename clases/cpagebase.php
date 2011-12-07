<?php

require_once("clanguage.php");
require_once("ccookie.php");
require_once("cform_construct.php");
require_once("csesion.php");

class Cpagebase
{
	
	//Atributes
	private $m_title;

	private $m_metas = array();
	private $m_styles = array();
	private $m_js_scripts = array();
	var $m_cookie = array();
	
	var $m_vars = array();
	
	private $m_heredoc_scripts;
	
	var $m_language;
	var $m_default_language;
	var $m_actual_language;
	
	var $m_sesion;
	var $m_has_link_blocker;
	
	var $m_forms = array();
	
	public $m_webinfo_state;
	public $m_webinfo_msg;
	
	private $m_app;
	
	var $m_browser;


	//Constructor
	
	function Cpagebase()
	{
		//inicializamos atributos
		$this->m_webinfo_state 		   = 	 "";
		$this->m_webinfo_msg 			   = 	 "";
		$this->m_app							   = 	 'web';
		$this->m_has_link_blocker    =   0;
		$this->m_heredoc_scripts     =   "";

	
		//Asignamos el lenguaje por defecto de la pagina por si no existe ninguno asignado
		$this->m_default_language = "es";
		
		
		//Buscamos el navegador
 		$this->m_browser = substr($_SERVER['HTTP_USER_AGENT'], 25, 8);
 		
		
		//Creamos el objeto de lenguage
		$this->m_language = new Clanguage(Cutils::get_actual_lng());

		
		//asignamos el valor del lenguaje actual
		$this->m_actual_language = Cutils::get_actual_lng(); 
		
		
		//codificacion de la pagina
		$this->add_metas('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />');
		$this->add_metas("<meta http-equiv='expires' content='1200' />");

		
		//idioma de la pagina
		$this->add_metas("<meta http-equiv='content-language' content='".Cutils::get_actual_lng()."' />");
						

		//insertamos jquery por defecto
		$this->add_js_scripts(PATH_ROOT_JS .'jquery.js');
		
		//insertamos development.js si esta definido
		if ( DEVELOPER_CONSOLE ){
			$this->add_js_scripts(PATH_ROOT_JS .'development.js');
		}
		
		
		//Creamos el objeto session si la pagina lo permite
		$this->m_sesion = new Csesion();
		
		
		//Creamos el objeto cookie y miramos si existe algun mensaje para mostrar. Si existe borramos la cookie
		$cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
		$this->m_webinfo_state  = ($cookie->ReadCookie('info_action'))  ? 	$cookie->ReadCookie('info_action')  : "";
		$this->m_webinfo_msg 		= ($cookie->ReadCookie('info_msg')) 		? 	$cookie->ReadCookie('info_msg') 		: "";
		
		if ($this->m_webinfo_msg) 
			$cookie->KillCookie('infos_S');
	
	}
	
	//Methods
	
	function set_page_app($app){
	  
	  $this->m_app = $app;
	  
	}
	
	
	function get_page_app(){
	  
	  return $this->m_app;
	  
	}
	
	
	function set_page_forms($forms){
	  
	  //Si hay formulario en la pagina hacemos el process correspondiente
		if ($forms)
		{
			foreach ($forms as $index => $value)
			{
				$this->m_forms[$index] = $value;
				$this->m_forms[$index]->set_form_language($this->m_actual_language);
				$this->m_forms[$index]->process();
			}
		}
	}
	
	
	function set_page_link_blocker($has_link_blocker){
	  
	  $this->m_has_link_blocker = $has_link_blocker;
	  
	}
	
	
	function set_page_session($has_session){
	  
	  $this->m_sesion = $has_session;
	  
	}
	
	
	function set_page_heredoc($heredoc){
	  
	  $this->m_heredoc_scripts = $heredoc;
	  
	}
	
	
	function set_page_js_scripts($js_scripts){
	  
	  if (is_array($js_scripts)){
	    
	    	foreach ($js_scripts as $js_script){
	    	  $this->add_js_scripts($js_script);
          }
             
	  }else{
	     $this->add_js_scripts($js_scripts);
	  }
	  
	}
	
	
	function set_page_styles($styles){
	  
	  if (is_array($styles)){
	    
	    	foreach ($styles as $style){
	    	  $this->add_styles($style);
          }   
          
	  }else{
	     $this->add_styles($styles);
	  }
	  
	}
	
	
	function set_page_metas($metas){
	 
		if (!empty($metas))
		{
			foreach ($metas as $key=>$value)
			{
				switch($key)
				{
					case 'description':
						$new_meta = "<meta name='description' content='$value' />";
					break;
					
					case 'keywords':
						$new_meta = "<meta name='keywords' content='$value' />";
					break;
					
					case 'title':
						$new_meta = "<title>$value</title>\n";
					break;

					case 'nocache':
						$new_meta = "<meta http-equiv='Cache-Control' content='no-cache, mustrevalidate'>";
					break;
					
					case 'canonical':
						$new_meta = "<link rel='canonical' href='$value' />";
						break;
					
					default:
						$new_meta= $value;
				}
				
				$this->add_metas($new_meta);
			}
		}
		
	}
	
	
	function get_language(){
		return $this->m_language;
	}
	
	
	function get_actual_language(){
		return $this->m_actual_language;
	}
	
	
	function add_form ($name, $form){
		$this->m_forms[$name] = $form;
	}
	
	
	function get_form_by_name($name){
		return $this->m_forms[$name];
	}
	
	
	function get_title(){
		return $this->m_title;
	}
	
	
	function get_link_active(){
		return $this->m_link_active;
	}
	
	
	function get_session(){
		return $this->m_sesion;
	}
	
	
	function add_styles($url){
		array_push($this->m_styles, $url);
	}
	
	
	function get_var($value){
		if (isset($this->m_vars[$value]))
			return $this->m_vars[$value];
		else 
			return false;
	}
	
	
	function set_var($name, $value){
		$this->m_vars[$name] = $value;
	}
	
	
	function exist_var($name){
		return  isset($this->m_vars[$name]);
	}
	
	
	function display_styles(){
		foreach ($this->m_styles as $value){
			echo " <link href='$value?".VERSION."' rel=\"stylesheet\" type=\"text/css\" />\n";
		}
	}
	
	
	function display_heredoc_scripts(){
		echo str_replace( '%%', $this->get_actual_language(), $this->m_heredoc_scripts);
		
		//Mostramos los scripts de bloqueo de link si es necesario
		if ($this->m_has_link_blocker)
			echo $this->display_link_blocker();
	}
	
	
	function display_link_blocker(){
		$message = $this->m_language->get_element_generic('wait');
		
		$path_admin_js 	= PATH_ROOT_JS;
		$path_admin_img = PATH_ROOT_IMG;
		
		$var = <<< HTML
		<script src="{$path_admin_js}jquery.blockUI.js" type="text/javascript"></script>
		<script>
		
		loadImage = new Image();
		loadImage.src = "{$path_admin_img}ajax-loader.gif";
				
		$(document).ready(function() { 
	    $('#submit').click(function() { 
	    	  if ( $(".formsweb").length > 0 )
	    	  {
	    	  	if ( $(".formsweb").valid() )
	    	  	{
	    	  	 
	    	  	  $.blockUI({ 
	            message: '<div class=ajaxloader_text>$message</div>', 
	            timeout: 120000
	        		}); 
	    	  	}
	    	  }
	    	  else
	    	  {
	    	  	$.blockUI({ 
	    	  	message: '<div class=ajaxloader_text>$message</div>',
	          timeout: 120000
	        	}); 	
	    	  }

	    }); 
		});
		</script> 
HTML;

		return $var;
	}
	
	
	function add_metas($meta){
		array_push($this->m_metas, $meta);
	}
		
	
	function display_metas(){
		if ($this->m_metas){
			foreach ($this->m_metas as $value){
				echo "$value\n";
			}
		}
	}
	
	
	function add_js_scripts($url){
		array_push($this->m_js_scripts, $url);
	}
	
	
	function display_js_scripts(){
		foreach ($this->m_js_scripts as $value){
			echo " <script language='JavaScript' charset='UTF-8' src='$value?".VERSION."'></script>\n";			
		}
	}
	
	
  function display_members(){
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
    echo "<head>\n";
    
    if ($this->m_app == 'movil')
    	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=yes' />";
    
    echo $this->get_title();
    
    $this->display_metas();
    
    $this->display_styles();
    
    $this->display_js_scripts();
    
    $this->display_heredoc_scripts();	
    	
    echo "</head>\n";
	}
	
	
	function close_page(){ 	
		echo "</html>\n";
	}
	
	
	function get_webinfo_state(){
		return $this->m_webinfo_state ;
	}
	
	
	function get_webinfo_msg(){
		return $this->m_webinfo_msg ;
	}
	
	
	function get_web_information($type='normal'){	
		$string = "";
		
		//Escribimos el mensaje por pantalla
		if ($this->m_webinfo_msg != '')
		{
			$class = ($this->get_webinfo_state()==1) ? "info_ok" : "info_ko"; 
			$class = ($type != 'normal') ? $class."_".$type : $class; 

			$string .= "<div class='$class'>";
			$string .= $this->get_webinfo_msg();
			$string .= "</div>";
		}
		
		return $string;
	}
	
	
	function write_web_information($msg = '', $state = 1, $type='normal'){	
		$string = "";
		
		//Escribimos el mensaje por pantalla
		if ($msg != '')
		{
			$class = ($state == 1) ? "info_ok" : "info_ko"; 
			$class = ($type != 'normal') ? $class."_".$type : $class; 
			$string .= "<div class='$class'>";
			$string .= $msg;
			$string .= "</div>";
		}
		
		return $string;
	}
	
	
	function translate($text, $params = ''){
	  
	  if (!$params)
	   return $this->get_language()->get_element_generic($text);
	  else 
	   return $this->get_language()->get_element_generic($text, $params);	  
  }


}
?>
