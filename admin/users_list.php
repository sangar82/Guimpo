<?php

require_once( '../config.php' );
require_once( PATH_ROOT_CLASES. 'cusers.php');
require_once( PATH_ROOT_CLASES. 'cutils.php');
require_once( PATH_ROOT_CLASES. 'cimagen.php');
require_once( PATH_ROOT_CLASES . 'cpagelayout_backend.php');
require_once( PATH_ROOT_CLASES . 'cform_construct_user.php');
require_once( PATH_ROOT_CLASES . 'csesion.php');


//Recojemos la pagina actual
$pag  = Cutils::get_filtered_params('pag', 0, 0, 1, 0); 
if ($pag == 0) $pag = 1;

//Creamos un array con los parametros que se enviaran a traves del paginado
$sort_dir  				= 		isset( $_REQUEST['sort_dir'])				? Cutils::get_filtered_params('sort_dir', 1, 0, 1, 0)	:   'desc';
$sort_by	  			= 		isset( $_REQUEST['sort_by'])				? Cutils::get_filtered_params('sort_by', 1, 0, 1, 0)	:   'id';
$newsort_dir 		= 		($sort_dir == 'desc') 											? 'asc' 																															:		'desc';
$search_text		=		isset( $_REQUEST['search_text'] )		?			htmlentities($_REQUEST['search_text']	)						: 	'';
$search_field		=		isset( $_REQUEST['search_field'] )		?			$_REQUEST['search_field']																: 	'';
$redirect_url			= Cutils::redirect_url_for_tablesorter($pag);

// Recogemos los parametros enviados para la ordenación y la busqueda para crear los numeros de página
$params_get		= Cutils::create_params_array_for_search_and_tablesorter($sort_by, $sort_dir, $search_text, $search_field );

// Construimos la url para la busqueda de campos
$heredoc = <<< html
	<script>
		$(document).ready(function(){

			$('.search').click(function() {
				var search_text  = escape( $('#search_text').val() );
				var search_field = $('#search_field').val();
				document.location = "$redirect_url?search_text="+search_text+"&search_field="+search_field;
				return false;
			});
		});
	</script>
html;

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

  $users = Cusers::item_list(MAX_ITEMS, $pag, $sort_by, $sort_dir, $search_text, $search_field);
  $paginate = new Cpaginado(MAX_ITEMS,$pag,$users['total'],$params_get); 
	$paginat_box = $paginate->RetornaPaginatLlistat('',false); 
	
  $layout->set_page_js_scripts(PATH_ROOT_JS. 'tableformat.js');
  $layout->set_page_heredoc($heredoc);
  
  $layout->set_var('users', $users['item']);
  $layout->set_var('items_total', $users['total']);
	$layout->set_var('paginate', $paginat_box);
	$layout->set_var('sort_dir', $sort_dir);
	$layout->set_var('newsort_dir', $newsort_dir);
	$layout->set_var('sort_by', $sort_by);
	$layout->set_var('redirect_url', $redirect_url);
	$layout->set_var('search_text', $search_text);
	$layout->set_var('search_field', $search_field);
$layout->Display();

?>
