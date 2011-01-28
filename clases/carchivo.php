<?php

include_once('cdatabase.php');
include_once('cutils.php');
	
class Carchivo{
  
  public $m_form_name;
	public $m_name;
	public $m_tmp_name;
	public $m_extensio;
	public $m_folder;
	public $m_archivo_type;
	public $m_type;
	public $m_size;
	
	public $m_error;
	
		
  function Carchivo($form_name, $type = 'image', $nombre = '', $folder = ''){
    
    $this->m_form_name = $form_name;
    
    
    if(isset($_FILES[$this->m_form_name.'_'.$type])){
      
      $this->m_type = $type;
      
      $this->m_archivo_type = $_FILES[$this->m_form_name.'_'.$type]['type'];
      
      $this->m_size = $_FILES[$this->m_form_name.'_'.$type]['size'];
      
      $this->m_tmp_name = $_FILES[$this->m_form_name.'_'.$type]['tmp_name'];
      
      $this->m_error = $_FILES[$this->m_form_name.'_'.$type]['error'];
      
      $x = explode('.',$_FILES[$this->m_form_name.'_'.$type]['name']);
      $this->m_extensio = $x[Count($x)-1];
     
      
      if ($type == 'image'){
        
        if ($nombre == '')
          $this->m_name = mktime().rand(1,1000);
        else 
          $this->m_name = $nombre;
          
      }else if ($type == 'file'){
        
           $this->m_name = $x[0];
        
      }
      

        
      $this->m_folder = $folder;
           
    }else{
      $this->m_no_photo;
      error_logger("no entra al constructor de archivo".var_export($_FILES, true),'ERROR');
    }
    

    
  }//end constructor
  
  
  function get_url_photo_to_save(){
    if ($this->m_error === 0){
       if ($this->m_folder){
        $return = $this->m_folder ."/". $this->m_name . '.' . $this->m_extensio;
      }else{
        $return = $this->m_name . '.' . $this->m_extensio;
      }
    }else 
      $return = '';
    
    return $return ;
  }
  
  
  function move(){
    
    if ($this->m_folder){
      $ruta = PATH_UPLOADS . $this->m_folder ."/". $this->m_name . '.' . $this->m_extensio;
      $return = $this->m_folder ."/". $this->m_name . '.' . $this->m_extensio;
    }else{
      $ruta = PATH_UPLOADS . $this->m_name . '.' . $this->m_extensio;
      $return = $this->m_name . '.' . $this->m_extensio;
    }
    
    //Mirar si existeix la carpeta dentro de uploads
    if ($this->m_folder){
      if ( !file_exists( PATH_UPLOADS.$this->m_folder ) )
         mkdir(PATH_UPLOADS.$this->m_folder);
    }
    
		//Mira si no existeix ja la imatge al servidor
		if(!file_exists($ruta)){
			$correct = move_uploaded_file($this->m_tmp_name,$ruta);
		}else{ 
		  $correct = 0;
		  $return = '';
		  error_logger("Error al subir la foto en la ruta $ruta",'ERROR');
		}

    return array('correct' => $correct, 'return' => $return);
  }
  
  
  static function delete($ruta){
    
    //Borramos la imagen
    if ( file_exists( PATH_UPLOADS.$ruta ) )
      unlink( PATH_UPLOADS.$ruta );

  }
  
  
  static function get_ruta_from_id($table, $id){
    
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $sql = "SELECT file FROM $table WHERE id=$id";
    
    $result = $con->fetch_one_result($sql);
    
    if ($result)
      return $result['file'];
    else 
      return false;
    
  }
  
  
  static function show_file($ruta) {
    
    return "<a href='".PATH_ROOT_UPLOADS."$ruta'>Download</a>";
  }
  
  
} //end clase
?>