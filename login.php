<?php
	
	require_once("config.php");
	require_once(PATH_ROOT_CLASES . 'cpagelayout_frontend.php');
	require_once(PATH_ROOT_CLASES . 'cform_construct_login.php');
	require_once(PATH_ROOT_CLASES . 'csesion.php');
	require_once(PATH_ROOT_CLASES . 'cutils.php');
	

  $names_section = array( 
    "top" 			=> 	"vtop_empty", 
    "menu" 			=> 	"vmenu", 
   // "main" 			=> 	"vlogin",
    "main" 			=> 	"vsignuplogin",
    "footer"		=>	"vfooter"
  );
	
						
	//Construimos el formulario y lo añadimos al array de formularios para pasarle a pagebase
	$form = new Cform_construct_login('cformlogin','es');
	$array_forms['cformlogin'] = $form;

	//heredoc scripts for javascript validation
	$heredoc = Cutils::get_scripts_heredoc_form_validation($array_forms);
	
	//meta para no cargar en cache
	$metas = array('nocache'=>'');
	
	//Borramos si existe la variable de sesion de usuarios por si ponen un mail ya creado
	$sesion = new Csesion();
	$sesion->delete_var_session('user');
	
  $layout	= new Cpagelayout_frontend($names_section);
  $layout->set_page_styles(PATH_ROOT_CSS . "styles.css");
  $layout->set_page_forms($array_forms); 
  $layout->set_page_heredoc($heredoc);
	$layout->Display();
	
?>
