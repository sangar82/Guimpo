<?php

require_once( '../config.php' );
require_once( PATH_ROOT_CLASES. 'cutils.php');
require_once( PATH_ROOT_CLASES . 'csesion.php');
require_once( PATH_ROOT_CLASES . 'cpagelayout_backend.php');


// Definimos las seccins del layout
$names_section = array( 
  "top" 			=> 	"vtop", 
  "menu" 			=> 	"vmenu", 
  "main" 			=> 	"vadmin_index",
  "footer"		=>	"vfooter"
);

//incluimos los metas
$metas = array(
  "description" 	=> 	"Descripción title", 
	"keywords" 			=> 	"keykords, keywords, keykords, keywords,keykords, keywords",
	"nocache"       =>  "" 
);


$layout	= new Cpagelayout_backend($names_section);
  
$layout->Display();



?>
