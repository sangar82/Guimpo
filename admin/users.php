<?php

require_once( '../config.php' );
require_once( PATH_ROOT_CLASES. 'cusers.php');
require_once( PATH_ROOT_CLASES. 'cutils.php');
require_once( PATH_ROOT_CLASES . 'cpagelayout_backend.php');


// Definimos las seccins del layout
$names_section = array( 
  "top" 			=> 	"vtop", 
  "menu" 			=> 	"vmenu", 
  "main" 			=> 	"vusers",
  "footer"		=>	"vfooter"
);

//Recojemos el id del usuario a updatear
$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);


$layout	= new Cpagelayout_backend( $names_section );
$item = new Cusers($id);
$layout->set_var('item',  $item->load_user_to_array() );
$layout->Display();



?>
