<?php

require_once("error_logger.inc.php");
require_once("clanguage.php");
//require_once("csesion.php");
//require_once("cutils.php");


define("PARAMETRO_CONTROL","p@RaM3tR0");


class Clocation
{
	//Atributes
	
	private $m_location;
	private $m_request_uri;
	private $m_referer;
	private $m_query_string;
	private $m_params = array();
	private $m_hash;
	private $m_lng;
	private $m_layout;
	
	
	//Constructor
	
	function Clocation( $lng = 'es', $layout = 'backend' )
	{
		$this->m_lng = new Clanguage($lng);
		
		$this->m_layout = $layout;
		
		$this->m_location = htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES);
		
		$this->m_request_uri = htmlentities($_SERVER['REQUEST_URI'],ENT_QUOTES);
		
		$this->m_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
		
		$this->m_query_string = $_SERVER['QUERY_STRING'];
		
		if ($this->m_query_string != "")
		{
			$this->url_to_array();
			
			if ($this->m_layout == 'backend')
			{
				$this->m_hash = $this->get_hash_params();
				
				if (isset($this->m_params['hk']))
				{
					if ($this->m_params['hk'] != $this->m_hash)
					{
						error_logger("Se han modificado los parametros. LOCATION: ".$this->m_location.". REFERER: ".$this->m_referer.". QUERYSTRING: ".$this->m_query_string.". HASH: ".$this->m_hash.".","EMERGENCY");
						
						Cutils::set_web_information(0,$this->m_lng->get_element_generic('parametros_modificados'));
						
						Clocation::header_location('http://www.dingdom.com/info_web.php');
						
						exit();
					}
				}
				else
				{
					error_logger("Se han modificado los parametros. LOCATION: ".$this->m_location.". REFERER: ".$this->m_referer.". QUERYSTRING: ".$this->m_query_string.". HASH: ".$this->m_hash.".","EMERGENCY");
					
					Cutils::set_web_information(0,$this->m_lng->get_element_generic('parametros_modificados'));
					
					Clocation::header_location('http://www.dingdom.com/info_web.php');
					
					exit();
				}
			}
		}
		else
		{
			$this->m_hash = "";
		}
	}
	
	
	//Methods
	
	function get_location()
	{
		return $this->m_location;
	}
	
	
	function get_request_uri()
	{
		return $this->m_request_uri;
	}
	
	
	function get_referer()
	{
		return $this->m_referer;
	}
	
	
	function get_query_string()
	{
		return $this->m_query_string;
	}
	
	
	function get_params()
	{
		return $this->m_params;
	}
	
	
	function exist_param_get( $param )
	{
		return isset($this->m_params[$param]);
	}
	
	
	function param_get( $param )
	{
		if ($this->exist_param_get($param))
		{
			return $this->m_params[$param];
		}
		else
		{
			return false;
		}
	}
	
	
	function go_to_url( $url = '', $params = array() )
	{
		if (($url == '') && ($this->m_layout != 'backend'))
		{
			if (strpos($this->m_location,'/index.php')===0)
			{
				$url = '/';
			}
			else
			{
				$url = $this->m_request_uri;
				
				if ($url != '')
				{
					$aux_url = explode('/',$url);
					
					if (is_array($aux_url))
					{
						if (strpos($aux_url[count($aux_url)-1],'?')!==false)
						{
							array_pop($aux_url);
						}
						
						$url = implode('/',$aux_url);
					}
				}
			}
		}
		else if ($url == '')
		{
			$url = $this->m_location;
		}
		
		if (count($params))
		{
			$params_url = $this->array_to_url($params);
			
			if ($params_url)
			{
				if ($this->m_layout == 'backend')
				{
					$params_url .= "&hk=". $this->get_hash_params($url,$params_url);
				}
				
				$url_return = $url ."?". $params_url;
				
				return $url_return;
			}
			else
			{
				return $url;
			}
		}
		else
		{
			return $url;
		}
	}
	
	
	function header_to_url( $url = '', $params = array() )
	{
		if (($url == '') && ($this->m_layout != 'backend'))
		{
			if (strpos($this->m_location,'/index.php')===0)
			{
				$url = '/';
			}
			else
			{
				$url = $this->m_request_uri;
				
				if ($url != '')
				{
					$aux_url = explode('/',$url);
					
					if (is_array($aux_url))
					{
						if (strpos($aux_url[count($aux_url)-1],'?')!==false)
						{
							array_pop($aux_url);
						}
						
						$url = implode('/',$aux_url);
					}
				}
			}
		}
		else if ($url == '')
		{
			$url = $this->m_location;
		}
		
		if (count($params))
		{
			$params_url = $this->array_to_url($params);
			
			if ($params_url)
			{
				if ($this->m_layout == 'backend')
				{
					$params_url .= "&hk=". $this->get_hash_params($url,$params_url);
				}
				
				$url_return = $url ."?". $params_url;
				
				header("Location: $url_return");
			}
			else
			{
				header("Location: $url");
			}
		}
		else
		{
			header("Location: $url");
		}
		
		exit();
	}
	
	
	private function url_to_array()
	{
		$auxArray = explode('&',$this->m_query_string);
		
		foreach ($auxArray as $val)
		{
			$aux2 = explode('=',$val);
			
			if (count($aux2)==2)
			{
				$this->m_params[$aux2[0]] = $aux2[1];
			}
		}
	}
	
	
	static function array_to_url( $values )
	{
		if( !is_array( $values ) )
		{
			return false;
		}
		
		$url = '';
		
		reset( $values );
		
		while( list( $k, $v ) = each( $values ) )
		{
			if( !is_object( $v ) )
			{
				if( is_array( $v ) )
				{
					reset( $v );
					
					while( list( $k2,$v2 ) = each( $v ) )
					{
						$url .= $url == '' ? $k.'['.$k2.']='.urlencode( $v2 ) : '&'.$k.'['.$k2.']='.urlencode( $v2 );
					}
				}
				else
				{
					$url .= $url == '' ? "$k=" . urlencode( $v ) : "&$k=" . urlencode( $v );
				}
			}
		}
		
		return $url;
	}
	
	
	private function get_hash_params( $url='' , $params_url = "" )
	{
		if ($params_url == "")
		{
			$params_url = $this->m_query_string;
		}
		
		$auxArray = explode('&',$params_url);
		
		$strhash = "";
		
		foreach ($auxArray as $val)
		{
			$aux2 = explode('=',$val);
			
			if ($aux2[0] != "hk")
			{
				$strhash .= $aux2[0];
				$strhash .= $aux2[1];
			}
		}
		
		
		$strhash .= ($url!='') ? obtenir_doc_php($url) : obtenir_doc_php(htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES));
		$strhash .= "_".PARAMETRO_CONTROL;
		
		return md5($strhash);
	}
	
	
	//Methods statics
	
	static function exist_var_get( $var )
	{
		return isset($_GET[$var]);
	}
	
	
	static function var_get( $var )
	{
		if (Clocation::exist_var_get($var))
		{
			return $_GET[$var];
		}
		else
		{
			return false;
		}
	}
	
	
	static function exist_var_request( $var )
	{
		return isset($_REQUEST[$var]);
	}
	
	
	static function var_request( $var )
	{
		if (Clocation::exist_var_request($var))
		{
			return $_REQUEST[$var];
		}
		else
		{
			return false;
		}
	}
	
	
	static function get_parameters_string()
	{
		return $_SERVER['QUERY_STRING'];
	}
	
	
	static function get_array_request()
	{
		if (count($_REQUEST) != 0)
		{
			$arrayrequest = $_REQUEST;
		}
		else
		{
			$arrayrequest = array();
		}
		
		return $arrayrequest;
	}
	
	
	static function header_location( $url = '', $params = array(), $layout = 'frontend', $anchor = '', $redirect = '' )
	{
		if (($url == '') && ($layout != 'backend'))
		{
			if (strpos(htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES),'/index.php')===0)
			{
				$url = '/';
			}
			else
			{
				$url = htmlentities($_SERVER['REQUEST_URI'],ENT_QUOTES);
				
				if ($url != '')
				{
					$aux_url = explode('/',$url);
					
					if (is_array($aux_url))
					{
						if (strpos($aux_url[count($aux_url)-1],'?')!==false)
						{
							array_pop($aux_url);
						}
						
						$url = implode('/',$aux_url);
					}
				}
			}
		}
		else if ($url == '')
		{
			$url = htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES);
		}
		
		if ($redirect == '301')
		{
			header("HTTP/1.1 301 Moved Permanently");
		}
		else if ($redirect == '302')
		{
			header("HTTP/1.1 302 Moved Temporarily");
		}
		else if ($redirect == '404')
		{
			header("HTTP/1.1 404 Not Found");
		}
		
		if (count($params))
		{
			$params_url = Clocation::array_to_url($params);
			
			if ($params_url)
			{
				if ($layout == 'backend')
				{
					$params_url .= "&hk=". Clocation::get_hash_header($params_url,$url);
				}
				
				$url_return = $url ."?". $params_url;
				
				if ($anchor != '')
				{
					header("Location: $url_return#$anchor");
				}
				else
				{
					header("Location: $url_return");
				}
			}
			else
			{
				if ($anchor != '')
				{
					header("Location: $url#$anchor");
				}
				else
				{
					header("Location: $url");
				}
			}
		}
		else
		{
			if ($anchor != '')
			{
				header("Location: $url#$anchor");
			}
			else
			{
				header("Location: $url");
			}
		}
		exit();
	}
	
	
	static function go_to_location( $url = '', $params = array(), $layout = 'backend' )
	{
		if (($url == '') && ($layout != 'backend'))
		{
			if (strpos(htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES),'/index.php')===0)
			{
				$url = '/';
			}
			else
			{
				$url = htmlentities($_SERVER['REQUEST_URI'],ENT_QUOTES);
				
				if ($url != '')
				{
					$aux_url = explode('/',$url);
					
					if (is_array($aux_url))
					{
						if (strpos($aux_url[count($aux_url)-1],'?')!==false)
						{
							array_pop($aux_url);
						}
						
						$url = implode('/',$aux_url);
					}
				}
			}
		}
		else if ($url == '')
		{
			$url = htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES);
		}
		
		if (count($params))
		{
			$params_url = Clocation::array_to_url($params);
			
			if ($params_url)
			{
				if ($layout == 'backend')
				{
					$params_url .= "&hk=". Clocation::get_hash_header($params_url,$url);
				}
				
				$url_return = $url ."?". $params_url;
				
				return $url_return;
			}
			else
			{
				return $url;
			}
		}
		else
		{
			return $url;
		}
	}
	
	
	static function get_var_referer()
	{
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
	}
	
	
	static function get_var_uri()
	{
		return isset($_SERVER['REQUEST_URI']) ? htmlentities($_SERVER['REQUEST_URI'],ENT_QUOTES) : "";
	}
	
	
	static function get_hash_header( $params_url , $url )
	{
		$auxArray = explode('&',$params_url);
		
		$strhash = "";
		
		foreach ($auxArray as $val)
		{
			$aux2 = explode('=',$val);
			
			if ($aux2[0] != "hk")
			{
				$strhash .= $aux2[0];
				$strhash .= $aux2[1];
			}
		}
		
		$strhash .= obtenir_doc_php($url);
		$strhash .= '_'.PARAMETRO_CONTROL;
		
		return md5($strhash);
	}
	
}

?>
