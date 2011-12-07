<?php

include_once('error_logger.inc.php');
include_once('cdeveloper_console.php');
include_once('clocation.php');
/**
 *
 */

#FUNCIONS de SUPORT
/**
 * A partir d'un array crea una cadena per connexió amb PSQL
 * @param <type> $item
 * @param <type> $key
 * @param <type> $connectionString
 */
function psqlstring ($item, $key, &$connectionString)
{
    $connectionString .= " " . $key . "=" . $item;
    $connectionString = ltrim($connectionString);
    # Si poso l'espai al final, no puc fer el trim dins de la funció, pq no sé mai quan acabarà.
    # Així, faig el trim a cada iteració. Només té sentit la primera vegada, pro bueno... */
}

/**
 * Controla si la primera paraula d'una query es la passada. Perfecte per comprovar si la query es tipus "INSERT", "SELECT, "UPDATE" o "CREATE", per exemple.
 * En cas de fallar aquesta comprovació, l'execució del script sencer es talla en sec, per evitar problemes.
 * @param string $query La query que s'ha de comprovar
 * @param string $firstWordRequired La primera paraula que ha de tenir.
 */
function controlFirstWord($query,$firstWordRequired)
{
    $comprovacions=explode(" ", $query);
    if(strtolower($comprovacions[0])!=strtolower($firstWordRequired))
    {
        trigger_error("Only '".strtoupper($firstWordRequired)."' allowed. Query given: " . $query);
        die();
    }
}



class cdatabase {

    var $user;
    var $password;
    var $host;
    var $port;
    var $dbname;

    var $connection; // Apuntador cap a la connexio.
    var $driver;

    /**
     * 
     * @param array $connectionArray Array with HOST, PORT, DBNAME, USER and PASSWORD keys required for connection.
     * @param string $driver driver for connections with database (mysql, postgresql...)
     */
    function __construct($connectionArray, $driver=DEFAULT_DRIVER)
    {
        $this->driver=strtolower($driver);
        switch ($this->driver)
        {
            case "postgresql":
            	$conexio = "host='".$connectionArray['host']."' port='".PORT."' user='".$connectionArray['user']."' password='".$connectionArray['password']."' dbname='".$connectionArray['dbname']."'";
                $this->connection=@pg_connect($conexio);
                break;
            case "mysql":
                if(isset($connectionArray['port']))
                {
                    $server=$connectionArray['host']. ":" . $connectionArray['port'];
                }
                else
                {
                    $server=$connectionArray['host'];
                }
                $this->connection = mysql_connect($server, $connectionArray['user'], $connectionArray['password']);
                mysql_select_db(DBNAME);
                break;
            default:
                break;
        }
    }
		
    
    function get_status_connection()
    {
    	return $this->connection;
    }
   	
    
    function fetch_array ($query, &$msgError = '', $cache = 0)
    {
    	/***** ACTIVE / DESACTIVE MEMCACHE *****/
    	if (!USE_MEMCACHE)
    	{
    		$cache = 0;
    	}
    	/*****************/
    	
    	if ($cache)
    	{
				$memcache=new Memcache;
				@$memcache->connect(IP_MEMCACHE, 11211) or $cache = 0;
    	}
    	
      controlFirstWord($query, "select");
      switch ($this->driver)
      {
           case "postgresql":
           			if ($cache)
           			{
           				$query_md5 = md5($query);
									$res = $memcache->get($query_md5);
									
									if ($res)
									{
										$perRetornar = $res;
									}
									else
									{
/******************* DEBUG **********************************/
error_logger("SICACHE_CONSULTA_ABANS: #$query#","DEBUG");
/************************************************************/
										
										$result = @pg_query($query);
										
/******************* DEBUG **********************************/
error_logger("SICACHE_CONSULTA_RESULT: #$query#. VARIABLE RESULT: #".var_export( $result, true)."#.","DEBUG");
/************************************************************/
										
										if ($result)
										{
											$perRetornar = @pg_fetch_all($result);
											
/******************* DEBUG **********************************/
error_logger("SICACHE_CONSULTA_PERRETORNAR: #$query#. VARIABLE PERRETORNAR: #".var_export( $perRetornar, true)."#.","DEBUG");
/************************************************************/
											
											$memcache->set($query_md5,$perRetornar,MEMCACHE_COMPRESSED,LIMIT_MEMCACHE);
										}
										else
										{
											$msgError = @pg_last_error($this->connection);
											error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
											$perRetornar = false;
										}
									}
           			}
           			else
           			{
/******************* DEBUG **********************************/
error_logger("NOCACHE_CONSULTA_ABANS: #$query#","DEBUG");
/************************************************************/
           				
           				$result = @pg_query($query);
									
/******************* DEBUG **********************************/
error_logger("NOCACHE_CONSULTA_RESULT: #$query#. VARIABLE RESULT: #".var_export( $result, true)."#.","DEBUG");
/************************************************************/
									
									if ($result)
									{
										$perRetornar = @pg_fetch_all($result);
										
/******************* DEBUG **********************************/
error_logger("NOCACHE_CONSULTA_PERRETORNAR: #$query#. VARIABLE PERRETORNAR: #".var_export( $perRetornar, true)."#.","DEBUG");
/************************************************************/
									}
									else
									{
										$msgError = @pg_last_error($this->connection);
										error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
										$perRetornar = false;
									}
           			}
              break;
           case "mysql":
               $result=mysql_query($query);
               
               if (DEVELOPER_CONSOLE){
		               	if (! $result){
		               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
		               	} else {
		               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
		               	}
               }
              
               # Aixó retorna una línia, ha de retornar tota la taula.
               $perRetornar=array();
               
               $i=0;
               
               while( $queryContent = mysql_fetch_assoc( $result ) )
               {
                   $perRetornar[$i]=$queryContent;
                   $i++;
               }
               
               if (DEVELOPER_CONSOLE){
		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               }
               
               unset ($i);
               break;
               
               
          default:
              $perRetornar=null;
              break;
      }
      return $perRetornar;
    }
		
    
    function insert($query, &$msgError = '')
    {
        controlFirstWord($query, "insert");
        switch ($this->driver)
        {
            case "postgresql":
                $perRetornar=@pg_query($query);
                if (!$perRetornar){
                	$msgError = @pg_last_error($this->connection);
				error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
				$perRetornar = false;
                }
                break;
            case "mysql":
                $perRetornar=mysql_query($query);
                
	               if (DEVELOPER_CONSOLE){
			               	if (! $perRetornar){
			               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
			               	} else {
			               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
			               	}

		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               }
	               
                if (!$perRetornar){
                	$msgError = mysql_error();
				error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
				$perRetornar = false;
                }
                break;
            default:
                $perRetornar=null;
                break;
        }
        return $perRetornar;
    }
    
    
    function create($query, &$msgError = '')
    {
        controlFirstWord($query, "create");
        switch ($this->driver)
        {
            case "postgresql":
                $perRetornar=@pg_query($query);
                if (!$perRetornar){
                	$msgError = @pg_last_error($this->connection);
				error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
				$perRetornar = false;
                }
                break;
            case "mysql":
                $perRetornar=mysql_query($query);
        	      if (DEVELOPER_CONSOLE){
			               	if (! $perRetornar){
			               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
			               	} else {
			               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
			               	}

		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               }
                if (!$perRetornar){
                	$msgError = mysql_error();
				error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
				$perRetornar = false;
                }
                break;
            default:
                $perRetornar=null;
                break;
        }
        return $perRetornar;
    }
    
    
    function delete($query, &$msgError = '')
    {
        controlFirstWord($query, "delete");
        switch ($this->driver)
        {
            case "postgresql":
                $perRetornar=@pg_query($query);
                if (!$perRetornar)
                {
                	$msgError = @pg_last_error($this->connection);
									error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
									$perRetornar = false;
                }
                break;
            case "mysql":
                $perRetornar=mysql_query($query);
        	      if (DEVELOPER_CONSOLE){
			               	if (! $perRetornar){
			               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
			               	} else {
			               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
			               	}

		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               }               
                break;
            default:
                $perRetornar=null;
                break;
        }
        return $perRetornar;
    }
    
    
    function drop($query, &$msgError = '')
    {
        controlFirstWord($query, "drop");
        switch ($this->driver)
        {
            case "postgresql":
                $perRetornar=@pg_query($query);
                if (!$perRetornar)
                {
                	$msgError = @pg_last_error($this->connection);
									error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
									$perRetornar = false;
                }
                break;
            case "mysql":
                $perRetornar=mysql_query($query);
        	      if (DEVELOPER_CONSOLE){
			               	if (! $perRetornar){
			               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
			               	} else {
			               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
			               	}

		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               	}
                break;
            default:
                $perRetornar=null;
                break;
        }
        return $perRetornar;
    }
    
    
    function update($query, &$msgError = '')
    {
        controlFirstWord($query, "update");
        switch ($this->driver)
        {
            case "postgresql":
                $perRetornar=@pg_query($query);
                if (!$perRetornar)
                {
                	$msgError = @pg_last_error($this->connection);
									error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
									$perRetornar = false;
                }
                break;
            case "mysql":
                $perRetornar=mysql_query($query);
        	       if (DEVELOPER_CONSOLE){
			               	if (! $perRetornar){
			               		Cdeveloper_console::add_query_to_developer_console($query, mysql_error());
			               	} else {
			               		Cdeveloper_console::add_query_to_developer_console($query, 'ok');
			               	}

		               	if ( $perRetornar ){
		               		Cdeveloper_console::add_result_to_developer_console($perRetornar);
		               	}
               	}
                break;
            default:
                $perRetornar=null;
                break;
        }
        return $perRetornar;
    }
		
    
    /**
     *
     * @return bool True for success, False in failure, null in missing database type.
     */
    function disconnect ()
    {
        /*switch ($this->driver)
        {
            case "postgresql":
                $perRetornar = @pg_close($this->connection);
                break;
            case "mysql":
                $perRetornar = mysql_close($this->connection);
                break;
            default:
                $perRetornar= null;
                break;
        }
        return $perRetornar;*/
    	
    	return true;
    }
		
    
    /**
     * Returns a complete row, but only one.
     * IMPORTANT: This function returns 0 or -2 in case of error. For compare values using a single-column queries (wich result can be "0" or "-2") use the triple equal (===) operator.
     * @param string $query
     * @return mixed 0 for no results, -2 for many rows in result, string for single-column queries or array with query result otherwise.
     */
    function fetch_one_result($query, $cache = 0)
    {
        $msg = '';
        $resultat = $this->fetch_array($query,$msg,$cache);

        if ($resultat==false) # No hi ha resultats
            $perRetornar = 0;
        else if(count($resultat)>1) # Hi ha més resultats dels esperats
            $perRetornar = -2;
        else # Correcte!
        {
            $perRetornar = $resultat[0];
        }
        
        
        
        return $perRetornar;
    }
    
    
		function last_insert_id($sequence, &$msgError = '')
		{
	    switch ($this->driver)
	    {
	        case "postgresql":
			        
			        $query = "SELECT currval('$sequence') as lastinsertid;";
			        $result = @pg_query($this->connection, $query);
			        
			        if ($result)
			        {
			        	$resultat = @pg_fetch_array($result);
			        	
			        	return $resultat['lastinsertid'];
			        }
			        else
			        {
			        	$msgError = @pg_last_error($this->connection);
								error_logger("Error al ejecutar la consulta. CONSULTA: $query. ERROR: $msgError.","ERROR");
								
			        	return false;
			        }
			        
			        break;
	        
	        case "mysql":
	       			
	        		break;
	    }
		}
		
		
		function affected_rows( $result )
		{
			switch ($this->driver)
	    {
	         case "postgresql":
	             $perRetornar=@pg_affected_rows( $result );
	            break;
	        case "mysql":
	            $perRetornar=mysql_affected_rows( $result );
	            break;
	        default:
	            $perRetornar=null;
	            break;
	    }
	    return $perRetornar;
		}
		
}

?>
