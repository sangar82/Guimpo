<?php

require_once( '../config.php' );
require_once(PATH_ROOT_CLASES . 'cdatabase.php');
require_once(PATH_ROOT_CLASES . 'cutils.php');
require_once(PATH_ROOT_CLASES . 'cusers.php');
require_once(PATH_ROOT_CLASES . 'csesion.php');

$action = Cutils::get_filtered_params('a', 1, 0, 1, 0);
$id     = Cutils::get_filtered_params('id', 1, 0, 1, 0);


//Miramos si esta logueado
$sesion = new Csesion();
$sesion->check();


if ($action == 'delete'){
  
  $user = new Cusers($id);
  
  $result = $user->delete();
  
  if ($result){
  
 		$info_ok = 1;
		$info_msg = 'Usuario eliminado correctamente';
		Cutils::set_web_information($info_ok, $info_msg);
		Clocation::header_location('/admin/users/list/');   
		
  } else {
    
    $info_ok = 0;
		$info_msg = 'Error eliminando usuario';
		Cutils::set_web_information($info_ok, $info_msg);
		Clocation::header_location('/admin/users/list/'); 
    
  }
  
}


?>