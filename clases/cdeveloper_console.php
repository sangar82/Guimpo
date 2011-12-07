<?php

require_once(PATH_ROOT_CLASES . 'cdatabase.php');
require_once(PATH_ROOT_CLASES . 'csesion.php');
require_once(PATH_ROOT_CLASES . 'cutils.php');

class Cdeveloper_console {
  
 // var $m_id;

	
	
  function Cdeveloper_console(){ 
		
  } //end construct
  
  
  static function add_query_to_developer_console($query, $result){
  	
  	$sesion = new Csesion();
  	
		  if ( ! $sesion->exists_var_session('developer') )	{
		
				$sesion->set_var_session('developer', array());
		  	
		  }
		  
		  array_push( $_SESSION['developer'], array('query'=> $query, 'result'=>$result , 'type'=> 'query'));	
		 
	} 
	
	
	 static function add_result_to_developer_console($result){
  	
  	$sesion = new Csesion();
  	
		  if ( ! $sesion->exists_var_session('developer') )	{
		
				$sesion->set_var_session('developer', array());
		  	
		  }
		  
		  array_push( $_SESSION['developer'], array('result'=> $result, 'type'=> 'result'));	
		 
	} 

	static function show_developer_console(){
		
		echo "<div id='developer_console'>";
		
		if (isset ( $_SESSION['developer'] ) ){

					
					foreach ($_SESSION['developer']  as $row){
						
						if ($row['type'] == "query"){
							
								if ($row['result'] == 'ok'){
									echo "<div class='dev_query'><span class='dev_green'>OK:</span> ".$row['query']." <a href='#'  class='dev_link_open'>Mostrar resultado</a><a href='#'  class='dev_link_close'>Cerrar</a></div>";
								} else {
									echo "<div class='dev_query'><span class='dev_red'>ERROR: </span> ".$row['query']."<br /><span class='red'>ERROR MSG:</span> ".$row['result']."</div>";
								}
					
						} else if ($row['type'] == "result"){
							echo "<div class='dev_pre'><pre>".var_export($row['result'], true)."</pre></div>";
						}
						
					}
			
		} else {
			echo "Ninguna consulta realizada.";
		}

		echo "</div>";
		
		unset( $_SESSION['developer'] );
		
	}


  
} //end class cusers


?>