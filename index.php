<?php

require_once('config.php'); 
require_once(PATH_ROOT_CLASES . 'cpagelayout_frontend.php');
require_once(PATH_ROOT_CLASES . 'cdatabase.php');
require_once(PATH_ROOT_CLASES . 'cutils.php');


$names_section = array( 
  "top" 			=> 	"vtop", 
  "menu" 			=> 	"vmenu", 
  "main" 			=> 	"vmain",
  "footer"		=>	"vfooter"
);

$layout	= new Cpagelayout_frontend( $names_section  );
$layout->Display();

?>
