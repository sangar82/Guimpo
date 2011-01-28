<?php

require_once('error_logger.inc.php');

class Cmail
{
	//Atributes
	var $m_from;
	var $m_to;
	var $m_asunto;
	var $m_body;
	var $m_headers;
	
	//Constructor
	function Cmail($from, $to, $asunto, $body){
		$this->m_from     = $from;
		$this->m_to       = $to;
		$this->m_asunto   = $asunto;
		$this->m_body     = $body;
		$this->m_headers  = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
	}
	
	
	function send(){

    //$cateceras .= "Reply-To: $remitente\r\n";
		
		$resultado = send_error_mail( SERVER_MAIL, PORT_MAIL, $this->m_from, $this->m_to, $this->m_asunto, $this->m_body, $this->m_headers, USER_MAIL, PASSWORD_MAIL );
		
		return $resultado;
	}
	
}

?>