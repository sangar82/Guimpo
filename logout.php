<?php
	
	require_once("config.php");
	require_once(PATH_ROOT_CLASES . 'csesion.php');
	require_once(PATH_ROOT_CLASES . 'cutils.php');
	require_once(PATH_ROOT_CLASES . 'clocation.php');
	
	//deslogueamos al usuario
  
	$session = new Csesion();
  
	if ( $session->exists() )
    $session->destroy();
  
  Clocation::header_location('/');
	
?>
