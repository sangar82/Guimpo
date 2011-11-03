<?php

//require_once(PATH_ROOT_CLASES . 'csesion.php');
require_once(PATH_ROOT_CLASES . 'ccookie.php');

class Cutils{
  
	/**
	* Return the actual language
	*
	* @return string $value Return the actual language in ISO format
	*/	
	static function get_filtered_lng(){
	  
		if ( strtolower($_SERVER['SERVER_NAME']) == 'en.framework.com' )
			$value = 'en';
		else if ( strtolower($_SERVER['SERVER_NAME']) == 'ca.framework.com' )
			$value = 'ca';
		else
			$value = 'es';
		
		return $value;
		
	}
	
	
	/**
	* Metodo que recoge variables request y redirige si no existen
	*
	* @param string $name_var Nombre de la variable que se quiere recoger
	* @param int $type Tipo de la variable : 0->entero, 1->string 
	* @param bool $with_redirect Indica si se debe redirigir si no se encuentra la variable definida en $_req
	* @param bool $is_public Indica si estamos en parte pública o privada
	* @param bool $with_session Indica si necesitamos acceder a las variables de sesion para guardar/recoger la variable
	* @return mixed Devuelve el valor del request con dicho nombre
	*/
	static function get_filtered_params($name_var, $type = 0, $with_redirect_if_error = 0, $is_public=0, $with_session = 0)
	{
		$error = false;		
		
		//Creamos la sesion
		//$sesio = new Csesion();
		
		if ( Clocation::exist_var_request($name_var) )
		{
			// Entero
			if ($type == 0)
			{
				//Validamos si es numerico y si es asi devolvemos el valor, si no redirigimos
				if ( is_numeric(Clocation::var_request($name_var)) )
				{
					if (strlen(Clocation::var_request($name_var)) > 9)
					{
						$value = doubleval(Clocation::var_request($name_var));
					}
					else 
					{
						$value = intval(Clocation::var_request($name_var));
					}
					
					if ($with_session)
						$sesio->setSesio($name_var,$value);		
				}
				else 
				{
					$error = true;
					$error_msg = "No ha validado el parametro '$name_var' de tipo entero. Hubo una modificación de parametros";
				}	
			}
			//Si es un string le hacemos un htmlentites con ent_quotes
			else if ($type == 1)
			{
				$value = htmlentities(Clocation::var_request($name_var),ENT_QUOTES);

				if ($with_session)
					$sesio->setSesio($name_var,$value);	
			}
		}
		/*else if ( $sesio->ExisteixValorSesio($name_var) and $with_session == 1)
		{
			$value = $sesio->getSesio($name_var);
		}*/
		else
		{
			$error = true;
			
			if ($with_redirect_if_error)
				$error_msg = "No se ha recibido el parametro '$name_var' necesario. Hubo una modificación de parametros";
		}
		
		if ($error)
		{
			if ($with_redirect_if_error)
			{
				// Si es publico o privado enviamos a un sitio diferente (ahora es el mismo)
				if ($is_public)
					$url_location = '/';
				else
					$url_location = '/admin/';
					
				error_logger($error_msg, 'EMERGENCY');	
				Cutils::header_if_no_params('msg_error', $url_location);

			}
			else 
			{
				// Como no redirigimos devolvemos valor vacio
				$value = "";
			}
		}
		return $value;
	}
	

	/**
	* Metodo para guardar en una cookie los valores de informacion despues de una accion
	*
	* @param int $info_action Codigo de error 0->ko 1->ok
	* @param string $info_msg Mensaje a mostrar
	* @return void
	*/	
	static function set_web_information($info_action, $info_msg, $with_language = 0)
	{		
		//Creamos el objeto de lenguage
		$lng = new Clanguage(Cutils::get_actual_lng());
		
		//Creamos una cookie con el mensaje a mostrar
		$cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
		
		if ($with_language)
			$msg_array = array('info_action' => $info_action, 'info_msg' => $lng->get_element_generic($info_msg) );
		else
			$msg_array = array('info_action' => $info_action, 'info_msg' => $info_msg );
			
	  $cookie->WriteCookie($msg_array);
	}

	
	
  function get_scripts_heredoc_form_validation($form, $special_class = '', $special_rules = '')
  {
  		$path_js = PATH_ROOT_JS;
  		$path_include = PATH_ROOT_INCLUDES;
  		
  		
  		$heredoc = <<< HTML
  		<script src='{$path_include}jquery.validate.php?lng=es' type='text/javascript'></script>
  		<script>	
    			$(document).ready(function(){
HTML;
  			     //por cada formulario incluimos su validacion			
  				foreach ($form as $index => $value){
  				 
  				  $heredoc .=  "$('#{$index}').validate($special_rules);";
  				  
  				}
  				
  				//$heredoc .=  "$('#{$index}').validate({errorLabelContainer: \"#error1\",wrapper: \"li\" });";
  				
                     if ($special_class){
                       
                       $heredoc .= "jQuery.validator.addClassRules({";
  				  
                       $special_class = explode(",", $special_class);
                       
                       foreach ($special_class as $special){
                         
                          if ($special == "image"){
  						$heredoc .= <<< HTML
  						      image: {
  							    required: false,
  							    accept: "jpg|jpeg|gif|png"
  							  },
HTML;
  					} else if ($special == "requiredimage"){
  						$heredoc .= <<< HTML
  						       image: {
  							    required: true,
  							    accept: "jpg|jpeg|gif|png"
  							  },
HTML;
  					} else if ($special == "doc"){
  						$heredoc .= <<< HTML
  						       doc: {
  							    required: false,
  							    accept: "doc|pdf"
  							  },
HTML;
  					} else if ($special == "requireddoc"){
  						$heredoc .= <<< HTML
  						       doc: {
  							    required: true,
  							    accept: "doc|pdf"
  							  },
HTML;
  					}else if ($special == "repassword"){
  						$heredoc .= <<< HTML
  							  password_again: {
  							    equalTo: "#password"
  							  },
  							  email_again: {
  							    equalTo: "#email"
  							  },
HTML;
   				
  					}
                         
                         
                       }
                       $heredoc = substr( $heredoc, 0, -1 );
                       $heredoc .= "});";
                       
  				}
  				
  		$heredoc .= "});</script>";
  				
  	return $heredoc;
  }	
	

  
	/**
	* Devuelve un array con los lenguages de la aplicación definidos en config.php
	*
	* @param void
	* @return array Lenguages de la aplicación
	*/	  
  static function get_web_languages(){
    
    $array_languages = explode('-', LANGUAGES);
    
    return $array_languages;
    
  }
  
  
/**
	* Devuelve el idioma actual.
	*
	* @return string $value Devuelve el valor ISO del idioma
	*/		
	static function get_actual_lng()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$pos = strpos($uri, "/admin/");
		
		if ($pos !== false){
			
			$value = ADMIN_LANGUAGE;
			
		} else {
		
				if ( strtolower($_SERVER['SERVER_NAME']) == 'en.'.DOMAIN )
					$value = 'en';
				else if ( strtolower($_SERVER['SERVER_NAME']) == 'ca.'.DOMAIN )
					$value = 'ca';
				else
					$value = 'es';
			
		}
		

			
		
		return $value;
	}
	
	


  /**
	* Devuelve un array con los lenguages de la aplicación definidos en config.php
	*
	* @param string text Texto a transformar
	* @return string Texto sin caracteres especiales ni raros para una url amigable
	*/

  static function to_stripped($url) {
  	// everything to lower and no spaces begin or end
  	$url = strtolower(trim($url));
  	
  	// decode html maybe needed if there's html I normally don't use this
  	$url = html_entity_decode($url,ENT_QUOTES,'UTF-8');
   
  	//replace accent characters, depends your language is needed
  	$url=Cutils::replace_accents($url);
   
  	// adding - for spaces and union characters
  	$find = array(' ', '&', '\r\n', '\n', '+',',');
  	$url = str_replace ($find, '-', $url);
   
  	//delete and replace rest of special chars
  	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
  	$repl = array('', '-', '');
  	$url = preg_replace ($find, $repl, $url);
   
  	//return the friendly url
  	return $url; 
  }
  

  

  /**
	* Devuelve un string con los caracteres especiales remplazados
	*
	* @param string text Texto a transformar
	* @return string Texto sin acentos ni caracteres raros
	*/  
  static function replace_accents($var){ 
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
    $var= str_replace($a, $b,$var);
    return $var; 
  }
 
  
  static function to_spanish_dates($date){
    //guarrada maxima
    if ($date != 1){
      list( $a, $m, $d ) = explode( "-", $date );
      return "$d-$m-$a";
    }
  }
  
  
  static function to_english_dates($date){
    list( $d, $m, $a ) = explode( "-", $date );
    return "$a-$m-$d";
  }
  
  static function to_gregorian_dates_array($date){
    list( $d, $m, $a ) = explode( "-", $date );
    $ret = array($m, $d, $a);
  
    return $ret;
  }
  
  /**
  * Función que crea un string aleatorio para confirmar un nuevo usuario
  *
  * @param int $length Número de dígitos a crear
  * @return string
  */		
  static function randomkeys($length){
    $key = "";
    //$pattern = "1234567890abcdefghijklmnopqrstuvwxyz!@#%&/()=[]{}+-*_ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $length_pattern = strlen($pattern)-1;
    
    for($i=0;$i<$length;$i++){
      $key .= $pattern{rand(0,$length_pattern)};
    }
    return $key;
  }
  
  
  static function redirect_url_for_tablesorter($pag){
  	
		if ($pag == 1){
			
			$redirect_url = $_SERVER['REDIRECT_URL'];
				
		} else {
			
			$aux_url = explode('/',  $_SERVER['REDIRECT_URL']);
			$count = count($aux_url);
			
			$redirect_url = "";
			for ($i = 0; $i < $count - 2; $i++){
				$redirect_url .=$aux_url[$i]."/";
			}
			
			return $redirect_url;
	
		} 	
  	
  }
  
  
  static function create_params_array_for_search_and_tablesorter($sort_by, $sort_dir, $search_text, $search_field ){
  	
  if ($search_text != ''){ 
	
			if ( isset( $_REQUEST['sort_by'] ) ){
				$params_get 		= 	array('sort_by'=>$sort_by, 'sort_dir'=>$sort_dir, 'search_text'=>$search_text, 'search_field'=>$search_field) ;
			} else {
				$params_get 		= 	array( 'search_text'=>$search_text, 'search_field'=>$search_field );
			}
		
		} else {
		
			if ( isset( $_REQUEST['sort_by'] ) ){
				$params_get 		= 	array('sort_by'=>$sort_by, 'sort_dir'=>$sort_dir);
			} else {
				$params_get 		= 	array();
			}
			
		}	
		
		return $params_get;
  	
  }

}//end cutils
?>