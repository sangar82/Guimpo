<?php

require_once( '../config.php' );
require_once( PATH_ROOT_CLASES. 'cusers.php');
require_once( PATH_ROOT_CLASES. 'cutils.php');
require_once( PATH_ROOT_CLASES. 'cimagen.php');
require_once( PATH_ROOT_CLASES . 'cpagelayout_backend.php');
require_once( PATH_ROOT_CLASES . 'cform_construct_user.php');
require_once( PATH_ROOT_CLASES . 'csesion.php');


// Definimos las seccins del layout
$names_section = array( 
  "top" 			=> 	"vtop", 
  "menu" 			=> 	"vmenu", 
  "main" 			=> 	"vusers_list",
  "footer"		=>	"vfooter"
);

//incluimos los metas
$metas = array(
  "description" 	=> 	"Descripción title", 
	"keywords" 			=> 	"keykords, keywords, keykords, keywords,keykords, keywords",
	"nocache"       =>  "" 
);

//Borramos si existe la variable de sesion de usuarios por si ponen un mail ya creado
$sesion = new Csesion();
$sesion->delete_var_session('user');


$layout	= new Cpagelayout_backend($names_section);
  $users = Cusers::item_list();
  $layout->set_page_js_scripts(PATH_ROOT_JS. 'tableformat.js');
  $layout->set_var('users', $users);
$layout->Display();

?>
