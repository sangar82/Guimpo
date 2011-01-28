<?php

include_once('cthumbnail.php');
include_once('carchivo.php');
	
class Cimagen extends Carchivo {
  
  function Cimagen($form_name, $type = 'image', $nombre = '', $folder = ''){
    
    Cimagen::Carchivo($form_name, $type , $nombre , $folder );
    
  }
  
  
  static function show_thumbnail($ruta)
  {
    $thumb = Cimagen::get_thumbnail($ruta);
    
    return "<img src='".PATH_ROOT_UPLOADS."$thumb' border='0'>";
  }
  
  
  static function get_thumbnail($ruta){
    
    $parse = explode('/', $ruta);
    
    $pos = count($parse) - 1;
    
    $aux = $parse[$pos];
    
    $parse[$pos] = 'thumbs';
    
    $parse[$pos + 1] = $aux;
    
    $ruta = implode('/', $parse);
    
    return $ruta;
    
  }
  
  static function get_ruta_from_id($table, $id){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $sql = "SELECT image FROM $table WHERE id=$id";
    
    $result = $con->fetch_one_result($sql);
    
    if ($result)
      return $result['image'];
    else 
      return false;
    
  }
  
  
  function do_thumbnail($ampleThumb=100, $altThumb=100, $crop=false, $midaCrop = 100){
  	
    //Funció que fa ús de la classe CThumbnails per crear el thumb d'una mida concreta.
    if ($this->m_folder){
      $ruta = PATH_UPLOADS . $this->m_folder ."/". $this->m_name . '.' . $this->m_extensio;
      $rutathumb = PATH_UPLOADS . $this->m_folder ."/thumbs/". $this->m_name . '.' . $this->m_extensio;
      $thumbfolder = PATH_UPLOADS . $this->m_folder ."/thumbs/";
    }else{ 
      $ruta = PATH_UPLOADS . $this->m_name . '.' . $this->m_extensio;
      $rutathumb = PATH_UPLOADS ."/thumbs/". $this->m_name . '.' . $this->m_extensio;
      $thumbfolder = PATH_UPLOADS ."/thumbs/";
    }
  	

    if ( !file_exists( $thumbfolder ) )
       mkdir($thumbfolder);
   
    
  	$thumb = new cThumbnail($ruta);
  	
  	if(!$crop){
  	  
  		if($thumb->getCurrentWidth()>$ampleThumb ){
  			
  			$thumb->cropFromCenter($thumb->getCurrentWidth());
  				
  			$thumb->resize($ampleThumb,$altThumb);
  			
  		}
  	
  	 $thumb->save($rutathumb);
  		
  	}	else { 
  		$thumb->cropFromCenter($midaCrop);
  		$thumb->save($rutathumb);
  	}
  }
  
  
  static function delete($ruta){
    
    //Borramos la imagen
    if ( file_exists( PATH_UPLOADS.$ruta ) )
      unlink( PATH_UPLOADS.$ruta );
      
    //Borramos el thumb
    if ( file_exists( PATH_UPLOADS.Cimagen::get_thumbnail($ruta) ) )
      unlink( PATH_UPLOADS.Cimagen::get_thumbnail($ruta) );
    
  }

  
  
}
?>