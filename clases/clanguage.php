<?php

require_once('error_logger.inc.php');

define( 'FILE_LANGUAGE', 'defines.php.lng' );
define( 'es', 'lng_es' );
define( 'en', 'lng_en' );
define( 'ca', 'lng_ca' );

class Clanguage
{
	//Atributes
	private $m_language; //Llenguatge que mostrara la pagina
	private $m_path_generic_file; //Ruta dels recursos generics a la pagina
	private $m_generic_array = array(); //Array amb el contingut del fitxer generic a tota la pagina
	private $m_is_generic; //Indica si l'array generic es ple o no
	
	//Constructor
	function Clanguage($language)
	{
		//ASSIGNEM LA RUTA DELS FITXERS DE CONFIGURACI� DEL LLENGUATGE
		
		$this->m_language = strtolower($language);
		
		if ($this->m_language == 'en')
		{
			$this->m_path_generic_file = 'generic/'. en;
		}
		else if ($this->m_language == 'ca')
		{
			$this->m_path_generic_file = 'generic/'. ca;
		}
		else
		{
			$this->m_path_generic_file = 'generic/'. es;
		}
		
		//ANALITZEM ELS FITXERS DE CONFIGURACI� DEL LLENGUATGE
		
		//GENERIC_ARRAY
		if (strpos(PATH_ROOT,'movil'))
			$generic_array = @file(PATH_ROOT ."../web/". $this->m_path_generic_file ."/". FILE_LANGUAGE);
		else
			$generic_array = @file(PATH_ROOT . $this->m_path_generic_file ."/". FILE_LANGUAGE);

		if (is_array($generic_array))
		{
			while (list (, $row) = each ($generic_array))
			{
			  if (substr($row,0,1)!=";" && substr($row,0,2)!="<?" && substr($row,0,2)!="?>" && strpos($row,"=") !== FALSE )
			  {
			    list ($index, $value) = split("=",$row, 2);
			    $this->m_generic_array[strtolower($index)] = chop($value);
			  }
			}
			
			$this->m_is_generic = true; //ASSIGNEM QUE L'ARRAY GENERIC ES PLE
			
			
		}
		else
		{	
			$this->m_is_generic = false; //ASSIGNEM QUE L'ARRAY GENERIC ES BUIT
			
			//---LOG-------
			$log_msg = "FILE(". PATH_ROOT . $this->m_path_generic_file ."/". FILE_LANGUAGE ."): FAILED TO OPEN STREAM: NO SUCH FILE OR DIRECTORY.";
			error_logger( $log_msg, 'EMERGENCY' );
			//---END LOG---
			
			die('SERVICE TEMPORARILY NOT AVAILABLE. WE ARE SORRY ABOUT THE INCONVENIENCES. PLEASE, REFRESH THE SITE IN A FEW MINUTES.');
		}
	}
	
	//Methods
	function get_language()
	{
		return $this->m_language;
	}
	
	function get_is_generic()
	{
		return $this->m_is_generic;
	}
	
	function is_element_generic_defined($element)
	{
		if ($this->get_is_generic())
  	{
	    $element = strtolower($element);
	    
	    $index_array = array_keys($this->m_generic_array);
	    
	    if (in_array($element,$index_array))
	    {
	      return true;
	    }
	    else
	    {
	      return false;
	    }
  	}
  	else
  	{
  		return false;
  	}
	}
	
	function get_element_generic($element, $parameters = array())
  {
  	if ($element != '')
  	{
	    if ($this->is_element_generic_defined($element))
	    {
	    	if (count($parameters) >= 1)
	    	{
	    		$langstring = $this->m_generic_array[$element];
	    		
	    		for ($i=0;$i<count($parameters);$i++)
	    		{
	    			$langstring = str_replace("%".$i."%",$parameters[$i],$langstring);
	    		}
	    		
	    		return $langstring;
	    	}
	    	else
	    	{
	    		return $this->m_generic_array[$element];
	    	}
	    }
	    else
	    {
	    	//---LOG-------
				$log_msg = "UNDEFINED ($element) IN THE FILE (". PATH_ROOT . $this->m_path_generic_file ."/". FILE_LANGUAGE .").";
				error_logger( $log_msg, 'ERROR' );
				//---END LOG---
	    	
	      return "#UNDEFINED [$element]";
	    }
  	}
  	else
  	{
  		return '';
  	}
	}
	
	
	
	function get_generic_path()
	{
		return $this->m_path_generic_file;
	}
	
	
	
	function translate($text, $params = ''){
	  if (!$params)
	   return $this->get_element_generic($text);
	  else 
	   return $this->get_element_generic($text, $params);  
	}
	
	
}

?>