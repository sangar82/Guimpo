<?php
    // cookieClass
    // Copyright (C) 2005 JRSofty Programming.
    // http://jrsofty1.stinkbugonline.com
    // Licensed under GNU/GPL 

    class Ccookie{
        
        var $cName = '';
        var $cTime = '';
        var $cSerialize = false;        
        var $cPath = '';

        
        	 /**
		     * User Constructor
		     * @param string $cookieName
		     * @param string $cookieTimeout  
			 * @param string $cookieSerialize Boolean
		     * @param string $cookiePath Enter a string as path 
		     * @return void
		     */
        function Ccookie($cookieName, $cookieTimeout, $cookieSerialize = false, $cookiePath = "/"){
            $this->cName = $cookieName;
            $this->cTime = $cookieTimeout;
            $this->cSerialize = $cookieSerialize;
            $this->cPath = $cookiePath;
            // This should fix the issue if you have cookies set and THEN turn on the serialization.
            $iname = $this->cName . "_S";
            if($this->cSerialize && !isset($_COOKIE[$iname])){
                $cookArr = array();
                foreach($_COOKIE as $name=>$val){				
                    if(strpos($name,$this->cName) !== false ){ // make sure it is a cookie set by this application
                        $subname = substr($name,strlen($this->cName) + 1);
                        $cookArr[$subname] = $val;
                        $this->KillCookie($name);
                    }
                }
                $this->WriteCookie($cookArr);
            }
            // This is the opposite from above. changes a serialized cookie to multiple cookies without loss of data
            if(!$this->cSerialize && isset($_COOKIE[$iname])){
                $cookArr = unserialize($_COOKIE[$iname]);
                $this->KillCookie($iname);
                $this->WriteCookie($cookArr);
            }
                        
                        
        }
        
        
        function DestroyAllCookies(){
            foreach($_COOKIE as $name=>$val){
                if(strpos($name,$this->cName) !== false){
                    $_COOKIE[$name] = NULL;
                    $this->KillCookie($name);
                }
            }
        }
        
        
        function ReadCookie($item){
            if($this->cSerialize){
                $name = $this->cName . "_S";
                if(isset($_COOKIE[$name])){
                    // handle the cookie as a serialzied variable
                    $sCookie = unserialize(stripslashes($_COOKIE[$name]));
                    if(isset($sCookie[$item])){
                        return $sCookie[$item];
                    }else{
                        return NULL;
                    }
                }else{
                    return NULL;
                }
            }else{
                $name = $this->cName . "_" . $item;
                if(isset($_COOKIE[$name])){
                    // handle the item as separate cookies
                    return $_COOKIE[$name];
                }else{
                    return NULL;
                }
            }    
        }
        
        
        function KillCookie($cName){
          $tStamp = time() - 432000;			
    			if($this->CheckName($cName)==false)
    				setcookie($cName,"",$tStamp,$this->cPath, '');
        }
        
        
        function WriteCookie($itemArr){
            if($this->cSerialize){                    
                $sItems = serialize($itemArr);
                $name = $this->cName . "_S";
                $_COOKIE[$name] = $sItems;
                $tStamp = time() + $this->cTime;
                setcookie($name,$sItems,$tStamp,$this->cPath, '');
            }else{
                $tStamp = time() + $this->cTime;
                foreach($itemArr as $nam=>$val){
                    $name = $this->cName . "_" . $nam;
                    $_COOKIE[$name] = $val;
                    setcookie($name,$val,$tStamp,$this->cPath, '');
                }
            }
        }
		
		
		//by nOFi
		function CheckName($nom)
		{
			return strpbrk($nom, "=,; \t\r\n\013\014");
		}
        
        
    } 
 ?>
