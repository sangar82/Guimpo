<?php

require_once(PATH_ROOT_CLASES . 'cdatabase.php');
require_once(PATH_ROOT_CLASES . 'cpaginado.php');
require_once(PATH_ROOT_CLASES . 'cutils.php');

class Cusers {
  
  var $m_id;
	var $m_name;
	var $m_lastname;
	var $m_username;
	var $m_password;
	var $m_type;
	var $m_email;
	var $m_created;
	var $m_updated;
	
	
  function Cusers($id = '', $username = '', $password = '', $name = '', $lastname = '', $email = '', $type = ''){ 
		
    if ($id == ''){
      
			$this->m_name 	  	   		=  $name;
			$this->m_lastname 	   	=  $lastname;    
			$this->m_username 	   	=  $username;
			$this->m_password 	   	=  md5($password);
			$this->m_email						= 	$email;
			$this->m_type							= 	$type;
			
		}else{
		  
		  $this->m_id			= $id;
			
			$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
			$query = "SELECT name, lastname, username, password, type, email, created, updated FROM users WHERE id=$id ";
			$user = $con->fetch_one_result($query);

			
			$this->m_name 	  			= $user['name'];
			$this->m_lastname 		= $user['lastname'];
			$this->m_username  	= $user['username'];
			$this->m_password  	= $user['password'];
			$this->m_email  				= $user['email'];
			$this->m_type	  				= $user['type'];
			$this->m_created  			= $user['created'];
			$this->m_updated  		= $user['updated'];
			
		}
		
  } //end construct
  
  
	/**
   * Save a new user
   * @return void 
   */  
  function save(){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $sql = "INSERT INTO users ( name, lastname, username, password, type, email) VALUES ('".$this->m_name."', '".$this->m_lastname."', '".$this->m_username."', '".$this->m_password."', '".$this->m_type."', '".$this->m_email."')";
    
    $result = $con->insert( $sql );
    
    if ($result)
      return true;
    else 
      return false;
  }
  
  
  function edit($name = '' , $lastname = '', $username = '', $password = '', $email = '', $type = ''){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $query = "UPDATE users SET ";
		
    $query.= ($name != '')		    	?		"name='$name', "			                  				:		"";	
		$query.= ($lastname != '')		?		"lastname='$lastname', " 			         		 	:		"";
		$query.= ($username != '')		?		"username='$username', "			          		:		"";
		$query.= ($email != '')					?		"email='$email', "			          								:		"";
		$query.= ($type != '')						?		"type='$type', "			          									:		"";
		$query.= ($password != '')		?		"password='".md5($password) ."', "			:		"";
		$query.= " updated=now()";
			
		$query.= " WHERE id=".$this->m_id.";";
		
		$result = $con->update($query);
		
    if ($result)
      return false;
    else 
      return true;		
    
  }
  
  
  static function item_list(){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $sql = "SELECT id, name, lastname, username, password, type, email, created, updated FROM users ORDER BY id desc";
    
    $result = $con->fetch_array($sql);
    
    if ($result)
      return $result;
    else 
      return false;
  }
  
  
  function delete(){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $user = $this->load_user_to_array();
    
    $sql = "DELETE FROM users WHERE id=".$this->m_id." ;";
    
    $result = $con->delete($sql);
    
    if ($result){
      return true;
    }else 
      return false;
  }
  
  
	function load_user_to_array(){
	  
	  $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
	  
	  $sql = "SELECT id, name, lastname, username, password, type, email, created, updated FROM users WHERE id=". $this->m_id;
    
    $result = $con->fetch_one_result($sql);
    
    if($result == 0 || $result == -2)
      return false;
    else 
      return $result;
      
	}
	
	
	static function login_user($username, $password){
	  
	  $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
	  
	  $sql = "SELECT id, name, lastname, username, password, type, email, created, updated FROM users WHERE username='". $username ."' and password = '".md5($password)."';";
	   
	  $result = $con->fetch_one_result($sql);
    
    if($result == 0 || $result == -2)
      return false;
    else 
      return $result['id'];
	     
	}
	
	static function exist_email($email){
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
	  
	  $sql = "SELECT id, email FROM users WHERE email='". $email ."';";
	   
	  $result = $con->fetch_one_result($sql);
    
    if($result == 0 || $result == -2)
      return false;
    else 
      return $result;
	}
	
	static function check_hash_change_email($hash){
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
	  
	  $sql = "SELECT id, hash FROM users WHERE hash='". $hash ."';";
	   
	  $result = $con->fetch_one_result($sql);
    
    if($result == 0 || $result == -2)
      return false;
    else 
      return $result;
		
	}
	
	static function create_hash_change_email($id){
		
		$hash = Cutils::randomkeys('40');
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $query = "UPDATE users SET hash='$hash', updated=now() WHERE id = $id ";
		
		$result = $con->update($query);
		
    if ($result)
      return $hash;
    else 
      return false;	
		
	}
	
	
	static function change_password($hash, $newpassword){
		
				$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
		    $query = "UPDATE users SET password='".md5($newpassword)."', hash='',  updated=now() WHERE hash = '$hash' ";
				
				$result = $con->update($query);
				
		    if ($result)
		      return true;
		    else 
		      return false;	
	}
	
	static function get_email_from_hash($hash){
		
		$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
	  
	  $sql = "SELECT id, email FROM users WHERE hash='". $hash ."';";
	   
	  $result = $con->fetch_one_result($sql);
    
    if($result == 0 || $result == -2)
      return false;
    else 
      return $result['email'];		
		
	}
	
  
} //end class cusers


?>