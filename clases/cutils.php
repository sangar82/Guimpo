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
	static function set_web_information($info_action, $info_msg)
	{		
		//Creamos una cookie con el mensaje a mostrar
		$cookie = new Ccookie('infos', EXPIRE_COOKIES_MSG, true);
		$msg_array = array('info_action' => $info_action, 'info_msg' => $info_msg );
	  $cookie->WriteCookie($msg_array);
	}

	
  function get_scripts_heredoc_form_validation($form, $special_class = '', $special_rules = '', $aux = '', $aux2 = '')
  {
  		$path_js = PATH_ROOT_JS;
  		$path_include = PATH_ROOT_INCLUDES;
  		
  		
  		$heredoc = <<< HTML
  		<script src='{$path_include}jquery.validate.php?lng=es' type='text/javascript'></script>
  		<script>		
    			$(document).ready(function(){
HTML;
  			  //por cada formulario incluimos su validacion			
  				foreach ($form as $index => $value)
  				{
  				 $heredoc .=  "$('#{$index}').validate($special_rules);";
  				}
  				//$heredoc .=  "$('#{$index}').validate({errorLabelContainer: \"#error1\",wrapper: \"li\" });";
  				
  				if ($special_class)
  				{
  					if ($special_class == "image")
  					{
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  image: 
  							  {
  							    required: false,
  							    accept: "jpg|jpeg|gif|png"
  							  }
  							});
  		
  		  			
HTML;
  					} else if ($special_class == "requiredimage"){
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  image: 
  							  {
  							    required: true,
  							    accept: "jpg|jpeg|gif|png"
  							  }
  							});
  		
  		  			
HTML;
  					} else if ($special_class == "doc"){
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  image: 
  							  {
  							    required: false,
  							    accept: "doc|pdf"
  							  }
  							});
  		
  		  			
HTML;
  					} else if ($special_class == "requireddoc"){
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  image: 
  							  {
  							    required: true,
  							    accept: "doc|pdf"
  							  }
  							});
  		
  		  			
HTML;
  					}
  					else if ($special_class == "mcalidad")
  					{
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  mcalidad:
  							  {
  							    required: true,
  							    accept: "pdf"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "planos")
  					{
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  mcalidad:
  							  {
  							    required: true,
  							    accept: "pdf|jpg|jpeg|gif|png"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "repassword")
  					{
  						$heredoc .= <<< HTML
  							jQuery.validator.addClassRules({
  							  password_again:
  							  {
  							    equalTo: "#password"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "username")
  					{
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  user:
  							  {
  							  	required: true,
    								remote: "includes/check_email.php"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "referencia_privada")
  					{
  						if ($aux)
  						{
  							$id_inmueble = "&id_inmueble=$aux";	
  						}
  						else 
  						{
  							$id_inmueble = "";
  						}
  						
  						if ($aux2)
  						{
  							$id_usuario = "?id_usuario=$aux2";	
  						}
  						else 
  						{
  							$id_usuario = "";
  						}
  						
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  rprivate:
  							  {
  							  	required: true,
    								remote: "includes/check_referencia.php{$id_usuario}{$id_inmueble}"
  							  }
  							});
  		
  		  			
HTML;
   			
  					}
  					else if ($special_class == "referencia_privada_promocion")
  					{
  						if ($aux)
  						{
  							$id_promocion = "&id_promocion=$aux";	
  						}
  						else 
  						{
  							$id_promocion = "";
  						}
  						
  						if ($aux2)
  						{
  							$id_usuario = "?id_usuario=$aux2";	
  						}
  						else 
  						{
  							$id_usuario = "";
  						}
  						
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  rprivatepromo:
  							  {
  							  	required: true,
    								remote: "includes/check_referencia_promo.php{$id_usuario}{$id_promocion}"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "username-repassword")
  					{
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  user:
  							  {
  							  	required: true,
    								remote: "includes/check_email.php"
  							  },
  							  password_again:
  							  {
  							    equalTo: "#new_password"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "username-repassword-admin")
  					{
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  user:
  							  {
  							  	required: true,
    								remote: "../includes/check_email.php"
  							  },
  							  password_again:
  							  {
  							    equalTo: "#new_password"
  							  }
  							});
  		
  		  			
HTML;
   				
  					}
  					else if ($special_class == "username-repassword-telefono")
  					{
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  user:
  							  {
  							  	required: true,
    								remote: "/includes/check_email.php"
  							  },
  							  password_again:
  							  {
  							    equalTo: "#new_password"
  							  },
  							  telf:
  							  {
  							 	  digits: true,
    								remote: "/includes/check_telefono.php"	
  							  }, 
  							  telf_alt:
  							  {
  							  	digits: true,
  							  	remote: "/includes/check_telefono.php"
  							  }
  							  
  							});			
HTML;
  					}
  					
  					else if ($special_class == "repassword-telefono-admin")
  					{
  						$heredoc .= <<< HTML
  
  							jQuery.validator.addClassRules({
  							  password_again:
  							  {
  							    equalTo: "#new_password"
  							  },
  							  telf:
  							  {
  							 	  digits: true,
    								remote: "../includes/check_telefono.php?id_usuario=$aux"	
  							  }, 
  							  telf_alt:
  							  {
  							  	digits: true,
  							  	remote: "../includes/check_telefono.php?id_usuario=$aux"
  							  }
  							  
  							});			
HTML;
  					}
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
    
    $array_languages = split('-', LANGUAGES);
    
    return $array_languages;
    
  }
  
  
/**
	* Devuelve el idioma actual.
	*
	* @return string $value Devuelve el valor ISO del idioma
	*/		
	static function get_actual_lng()
	{

		if ( strtolower($_SERVER['SERVER_NAME']) == 'en.'.DOMAIN )
			$value = 'en';
		else if ( strtolower($_SERVER['SERVER_NAME']) == 'ca.'.DOMAIN )
			$value = 'ca';
		else
			$value = 'es';
			
		
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

}//end cutils
?>