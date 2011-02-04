<?php
	
require_once('cusers.php');

	class Csesion{
		
	  private $m_frase = "s3gureTaT";
	  private $m_frase2 = "tok3nitZanT";
		
		
		function Csesion(){
		  
			if(!$this->exists()) {
				
			  $lifetime = time() + 9999999;
				session_set_cookie_params($lifetime,"/",DOMAIN, 0);
				session_start();
				
			}
		}
		
		
		static function exists(){
			
		  return isset($_SESSION);
		  
		}
		
		
		function create($id){
		  
			$result = false;
			//borrem sessio antiga
			session_unset();
			
			//aconseguir id_tipo_usuario
			$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER);
			$sel = "SELECT id, name, lastname, username, password, type, created, updated FROM users WHERE id=$id;";

			$user = $con->fetch_one_result($sel);
			
			if($user)
			{
				$_SESSION['fingerprint'] = $this->Fingerprint();
				
				$_SESSION['id'] = $user['id'];
				
				$_SESSION['username'] = $user['username'];
				
				$_SESSION['name'] = $user['name'];
				
				$_SESSION['lastname'] = $user['lastname'];
				
				$_SESSION['type'] = $user['type'];
				
				$_SESSION['time'] = time();

				$this->genera_token();
				
				$this->RegeneraID();
				
				$result = true;
			}
					
			return $result;
		}
		
		
		function check($sense_redireccio=false){
		  
		  //Comprobar que la sessio sigui correcte
			$correct = false;
			$x=0;
			
			if($this->exists_var_session('fingerprint'))
			{
				if($_SESSION['fingerprint']==$this->Fingerprint())
				{
					$correct = $this->checktime();
					
					if(!$correct) 
					 $x=1;
				}
			}
 
			if(!$correct && !$sense_redireccio) 
			{
				$this->incorrect_msg_session($x);
				$this->redirect();
				exit();
			}
			return $correct;
		}
		
		
		private function checktime()
		{//checkr que no es pasi de 20min la sessio
			$temps=9999999999;
			
			$actual=mktime();
			
			$anterior=$this->get_var_session('time');
			
			if ( ($actual - $anterior) > $temps ){
			  //Si es supera el temps de sessio..
				$result = false;
			}else {
			  //Si no es supera els 10minuts, actualitzem el temps.
				$this->set_var_session('time',$actual);
				$result = true;
			}
			
			return $result;
		}
		
		
		function redirect(){
		  
			//volcat dels valors GET
			$str_get='';
			
			foreach($_GET as $clau=>$val){
				$str_get.=htmlentities(($clau.'='.$val),ENT_QUOTES).'&';
			}

			//redirigim
			header("Location:/login/");
			
			exit();
		}
		
		
		private function Fingerprint(){
			
		  $fingerprint = $this->m_frase;
			$fingerprint .= (isset($_SERVER['HTTP_USER_AGENT']))?$_SERVER['HTTP_USER_AGENT']:'UserAgent';
			$fingerprint .= $_SERVER['REMOTE_ADDR'];
			
			return md5($fingerprint);
			
		}
		
		
		private function incorrect_msg_session($x)
		{
			if(!$this->exists()) 
			 session_start();
			 
			//obtenemos el idioma actual
			$actual_language = Cutils::get_filtered_lng();

			//Creamos un objeto lenguaje para traducciones
			$language = new Clanguage($actual_language);
			
			if($x) 
				$info_msg = $language->get_element_generic('session_expirada');
			else 
				$info_msg = $language->get_element_generic('session_incorrecta');
			
			Cutils::set_web_information(0,$info_msg);
		}
		
		
		private function RegeneraID(){
		  
		  session_regenerate_id(true);
		  
		}
		
	
		function exists_var_session($valor){
		  
			$retorn = false;
			
			if($this->exists()) 
			 $retorn = isset($_SESSION[$valor]);
			
			return $retorn;
			
		}
    

		function delete_var_session($valor){
		  
			unset($_SESSION[$valor]);
			
		}
    

		function get_var_session($variable){
			
		  return (isset($_SESSION[$variable]))?$_SESSION[$variable]:false;
		  
		}
		
		
		function set_var_session($variable,$valor){
		  
			$_SESSION[$variable] = $valor;
			
		}
		

		function destroy(){
		  
			session_unset();
			
			session_destroy();
			
			setcookie('PHPSESSID','aaa',time()-1000,'/', DOMAIN);
		}
	
		
		function redirect_index_admin()
		{
			header("Location:/admin/index.php");
			exit();
		}
		
		

		function genera_token(){
			$_SESSION['token_csrf'] = sha1($this->m_frase2 . uniqid(mt_rand(),TRUE));
		}
		
		
		function get_token(){
		  
			return $_SESSION['token_csrf'];
		}
		
		
		function check_token($token){
			
		  $correct = false;
			
		  if(isset($token) && isset($_SESSION['token_csrf'])){
		    
				$correct = $token == $_SESSION['token_csrf'];
				
			}
			
			return $correct;
		}

		
		
	}
	
?>
