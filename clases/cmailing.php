<?php

class Cmailing{
	
	var $m_from;
	var $m_to;
	var $m_asunto;
	var $m_body;
	var $m_headers;
	
	function Cmailing( $from = '', $to = '', $asunto = '', $body = '' ){
		
		$this->m_from     	= $from;
		$this->m_to       		= $to;
		$this->m_asunto   	= $asunto;
		$this->m_body     	= $body;
		$this->m_headers  = 'From: '.$from.'' . "\r\n" .
			    												 'Reply-To: '.$from.'' . "\r\n" .
			                             'Content-type: text/html' . "\r\n" .
			    												 'X-Mailer: PHP/' . phpversion();
	}
	
	
	function send(){
		    
		$resultado = mail( $this->m_to , $this->m_asunto , $this->m_body , $this->m_headers );
		 		
		return $resultado;
	}
	
}

?>