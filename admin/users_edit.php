<?php

require_once( '../config.php' );
require_once( PATH_ROOT_CLASES. 'cusers.php');
require_once( PATH_ROOT_CLASES. 'cutils.php');
require_once( PATH_ROOT_CLASES . 'cpagelayout_backend.php');
require_once( PATH_ROOT_CLASES . 'cform_construct_user.php');


// Definimos las seccins del layout
$names_section = array( 
  "top" 			=> 	"vtop", 
  "menu" 			=> 	"vmenu", 
  "main" 			=> 	"vusers_create",
  "footer"		=>	"vfooter"
);

//incluimos los metas
$metas = array(
  "description" 	=> 	"Descripción title", 
	"keywords" 			=> 	"keykords, keywords, keykords, keywords,keykords, keywords" 
);


//Recojemos el id del usuario a updatear
$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);

//incluimos el formulario de usuarios y lo añadimos al array de formularios
$newuser = new Cform_construct_user('cformusers','es','edit', $id, 'backend');
$array_forms['cformusers'] = $newuser; 

//incluimos la validacion por javascript
$heredoc = Cutils::get_scripts_heredoc_form_validation($array_forms , 'repassword' );

$heredoc .= <<< html
<script>
		$(document).ready(function(){
	        $("#re_email").val($("#email").val()); 
	 });
</script>
html;

$layout	= new Cpagelayout_backend( $names_section );
  $layout->set_page_heredoc($heredoc);
  $layout->set_page_forms($array_forms);
  $layout->set_var('form_type', 'edit');
  $layout->Display();



?>
