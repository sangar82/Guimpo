<?php require_once('../config.php'); require_once(PATH_ROOT_CLASES . 'ccategoria_gallery.php'); require_once(PATH_ROOT_CLASES . 'cform_construct_categoria_gallery.php'); require_once(PATH_ROOT_CLASES . 'cpagelayout_backend.php'); require_once(PATH_ROOT_CLASES . 'cimagen.php'); require_once(PATH_ROOT_CLASES . 'cutils.php');  require_once(PATH_ROOT_CLASES . 'ccategoria.php'); // Definimos las seccins del layout $names_section = array( 	'top' 			=> 	'vtop', 	'menu' 			=> 	'vmenu',  	'main' 			=> 	'vcategoria_gallery_create', 	'footer'		=>	'vfooter' );//Recojemos el id del usuario a verif ( isset( $_REQUEST['id']) )	$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);else{	$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0);	$id = Ccategoria_gallery::get_id_from_stripped($stripped);}//Miramos si existe. Si no existe enviamos a list$categoria_gallery = new Ccategoria_gallery($id);if (!$categoria_gallery->exists() and !isset($_REQUEST['cformcategoria_gallery_item_id'])){	Cutils::set_web_information(0, 'El item no existe o ha sido eliminado de la base de datos');	Clocation::header_location('/categoria_gallery/list/');}//recogemos la relacion que puede ser un stripped o un id if ( isset( $_REQUEST['categoria_id']) or isset($_REQUEST['cformcategoria_gallery_categoria_id'] ) ){ 	$categoria_id  = Cutils::get_filtered_params('categoria_id', 1, 0, 1, 0); 	$return  =  $categoria_id;}else if ( isset( $_REQUEST['stripped_id']) ){ 	$stripped_id = Cutils::get_filtered_params('stripped_id', 1, 0, 1, 0); 	$categoria_id = Ccategoria::get_id_from_stripped($stripped_id); 	$return = $stripped_id; } //incluimos el formulario de usuarios y lo añadimos al array de formularios$newform = new Cform_construct_categoria_gallery('cformcategoria_gallery','es','edit', $id, $categoria_id, $return);$array_forms['cformcategoria_gallery'] = $newform; //incluimos la validacion por javascript$heredoc = Cutils::get_scripts_heredoc_form_validation($array_forms );$layout	= new Cpagelayout_backend( $names_section ); 	$layout->set_page_link_blocker(true);	$layout->set_page_forms($array_forms);	$layout->set_page_heredoc($heredoc);	$layout->set_var('form_type', 'edit');	$layout->set_var('id', $id);	$layout->set_var('table', 'categoria_gallery');	$layout->set_var('return', $return);	$layout->set_var('rid', $categoria_id);$layout->Display();?>