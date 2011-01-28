<?php
 

function error_logger( $error = 'Undefined error', $error_level = 'ERROR', $error_type = 'ERRORS' )
{
	// Seek for the ini file, in case it's in a higher directory rather than in the current one.
	$previous_dirname = getcwd();
	$inifilename = 'config.ini.php';
	$found = false;
	$end = false;
	while( !$found and !$end )
	{
		$analizing_dir = getcwd();
		if( is_file( $inifilename ) and file_exists( $analizing_dir . '/' . $inifilename ) )
		{
			$found = true;
		}
		else 
		{
			if( !chdir( '..' ) or $analizing_dir == getcwd() )
			{
				$end = true;
			}
		}
	}


	
	if( $found )
	{
		// Read the ini file to get the log filename and the minimum logged level.
		$inifile = parse_ini_file( $inifilename, TRUE );
		$log_level = $inifile['logFile']['Level'];
		
		if( get_log_level($error_level) <= $log_level ) 
		{

			$log_file = $inifile['logFile']['FileNameErrors'];
			

			$log_file = parse_filename( $log_file );
			$date_format = $inifile['logFile']['DateFormat'];
			
			
			// Defines the error message to write to log file
			$error_stamp = get_error_stamp(); 
			$remote_host = $_SERVER['HTTP_HOST'];
			$remote_uri = $_SERVER['PHP_SELF']; //$remote_uri = $_SERVER['REQUEST_URI'];
			$request_method = $_SERVER['REQUEST_METHOD'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = date( $date_format );

			$error_message = " Error Stamp: [$error_stamp] \r\n";
			$error_message .= " Error Level: [$error_level] \r\n";
			$error_message .= " Remote Host: [$remote_host] \r\n";
			$error_message .= " Remote URI: [$remote_uri] \r\n";
			$error_message .= " Request Method: [$request_method] \r\n";
			
			if( $request_method == 'GET' )
			{
				$error_message .= " GET Variables: [";
				foreach( $_GET as $key => $value )
				{
					$error_message .= "$key=$value&";
				}
				$error_message = rtrim( $error_message, "&" );
				$error_message .= "] \r\n";
			}
			elseif( $request_method == 'POST' )
			{
				$error_message .= " POST Variables: [";
				foreach( $_POST as $key => $value )
				{
				$error_message .= "$key=$value&";
				}
				$error_message = rtrim( $error_message, "&" );
				$error_message .= "] \r\n";
			}
			$error_message .= " Timestamp: [$date] \r\n";
			$error_message .= " IP user: [$ip] \r\n";
			$error_message .= " Error Message: [$error] \r\n";
			$error_message .= "=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=\r\n";
			
			
			//obtenir ruta del fitxer

			$ruta_fitxer= $log_file;
			
			
			// Writes to file
			if( @error_log( $error_message, 3, $ruta_fitxer ) !== FALSE )
			{
				chdir( $previous_dirname );
				return $error_stamp;
			}
			else 
			{
				// Sends an E-Mail
				$mail_server = $inifile['mail']['Server'];
				$mail_port = $inifile['mail']['Port'];
				$mail_usr = $inifile['mail']['Usr'];
				$mail_pwd = $inifile['mail']['Pwd'];
				$mail_from = $inifile['mail']['From'];
				$mail_to = $inifile['mail']['To'];
				send_error_mail( $mail_server, $mail_port, $mail_from, $mail_to, 'Error Logger', "Unnable to write the message [$error_message] to the log file [$log_file]", '', $mail_usr, $mail_pwd );
			}
		}
	}
	else 
	{
		//FAIL!
	}

	// Goes back to the previous directory.
	chdir( $previous_dirname );

	return FALSE;
 	
}
 
 
 
function parse_filename( $filename )
{
	$filename = str_replace( '%y', date( 'Y' ), $filename );
	$filename = str_replace( '%m', date( 'm' ), $filename );
	$filename = str_replace( '%d', date( 'd' ), $filename );
	$filename = str_replace( '%H', date( 'H' ), $filename );
	$filename = str_replace( '%M', date( 'i' ), $filename );
	$filename = str_replace( '%S', date( 's' ), $filename );
	
	return $filename;
}

 
 
function get_log_level( $error_level )
{
	$error_levels = array( 'TRACE' => 8, 'DEBUG' => 7, 'INFO' => 6, 'NOTICE' => 5, 
	                       'WARNING' => 4, 'ERROR' => 3, 'CRITICAL' => 2, 'ALERT' => 1, 
	                       'EMERGENCY' => 0 );
	
	if( array_key_exists( $error_level, $error_levels ) )
	{
		return $error_levels[$error_level];
	}
	else 
	{
		return 0;
	}
}
 
 

function get_error_stamp()
{
	list( $usec, $sec ) = explode( ' ', microtime() );
 $stamp = ( ( float )$usec + ( float )$sec );
 return bin2hex( $stamp );
}


function filtre_antiCRLF($str)
{
	return eregi_replace("[\n|\r]",'',stripslashes($str));
}


function send_error_mail( $server, $port, $from, $to, $subject, $message, $headers='', $usr = NULL, $pwd = NULL )
{
	//FILTRAT DE VARIABLES per evitar CRLF
	$server=filtre_antiCRLF($server);
	$port=filtre_antiCRLF($port);
	$from=filtre_antiCRLF($from);
	$to=filtre_antiCRLF($to);
	$subject=filtre_antiCRLF($subject);
	$message=filtre_antiCRLF($message);
	$headers.= "To: $to\r\n";
	$headers .= "From: $from\r\n";
 	//
	
	// Open an SMTP connection
	$cp = @fsockopen ($server, $port);
	if (!$cp) return 'Failed to even make a connection';
	$res=fgets($cp,256);
	if(substr($res,0,3) != '220') return 'Failed to connect';

	// Say hello...
	fputs($cp, "HELO $server\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '250') 
	return 'Failed to Introduce';   

	if( ( $usr !== NULL ) and ( $pwd !== NULL ) )
	{
		// perform authentication
		fputs($cp, "auth login\r\n");
		$res=fgets($cp,256);
		if(substr($res,0,3) != '334') return 'Failed to Initiate Authentication';

		fputs($cp, base64_encode($usr)."\r\n");
		$res=fgets($cp,256);
		if(substr($res,0,3) != '334') return 'Failed to Provide Username for Authentication';

		fputs($cp, base64_encode($pwd)."\r\n");
		$res=fgets($cp,256);
		if(substr($res,0,3) != '235') return 'Failed to Authenticate';
	}

	// Mail from...
	fputs($cp, "MAIL FROM: <$from>\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '250') return 'MAIL FROM failed';

	// Rcpt to...
	fputs($cp, "RCPT TO: <$to>\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '250') return 'RCPT TO failed<br>'.$res."<br><br>$cosMail<br>";

	// Data...
	fputs($cp, "DATA\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '354') return 'DATA failed';

	// Send To:, From:, Subject:, other headers, blank line, message, and finish
	// with a period on its own line (for end of message)
	fputs($cp, "From: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '250') return 'Message Body Failed';
	
	// ...And time to quit...
	fputs($cp,"QUIT\r\n");
	$res=fgets($cp,256);
	if(substr($res,0,3) != '221') return 'QUIT failed';
	
	return true;
}


?>
