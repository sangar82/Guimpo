<?php

//Domain
define( "DOMAIN",  'guimpo.com') ;

//Numbers List Rows
define( "MAX_ITEMS", 12);

//Languages
define('LANGUAGES'							, 'es-ca-en');
define('ADMIN_LANGUAGE'		, 'es');

//Database
define('DBDRIVER'				,	'mysql');  //mysql - postgres
define('HOST'								, 'localhost');
define('PORT'								,	'3306');
define('USER'								,	'root');
define('PASSWORD'			,	'root');
define('DBNAME'					,	'framework');

//Mailing
define('EMAIL_COMPANY'				, "sangar1982@gmail.com");
define('EMAIL_DEVELOPER'		, "sangar1982@gmail.com");

//Expires Cookie time
define( "EXPIRE_COOKIES_MSG",  600000) ;

//Developer Console
define( "DEVELOPER_CONSOLE",  false) ;

//PATHS - Don´t change this
define( "PATH_ROOT"															, 	$_SERVER['DOCUMENT_ROOT'] . "/");
define( "PATH_ROOT_CLASES"								, 	PATH_ROOT ."/clases/");
define( "PATH_UPLOADS"												, 	PATH_ROOT ."img/uploads/" );
define( "PATH_ADMIN"														, 	PATH_ROOT ."admin/" );
define( "PATH_ROOT_CSS"											, 	"http://www.".DOMAIN."/css/" );
define( "PATH_ROOT_IMG"											, 	"http://www.".DOMAIN."/img/" );
define( "PATH_ROOT_MULTIMEDIA"				, 	"http://www.".DOMAIN."/multimedia/" );
define( "PATH_ROOT_UPLOADS"						, 	"http://www.".DOMAIN."/img/uploads/" );
define( "PATH_ROOT_INCLUDES"						, 	"http://www.".DOMAIN."/includes/" );
define( "PATH_ROOT_JS"												, 	"http://www.".DOMAIN."/js/");

//Others define not used yet
define( "ENVIRONMENT"						,  'local') ;
define( "VERSION"										,  '1') ;
define( "IP_MEMCACHE"						, "172.26.0.7" );
define( "USE_MEMCACHE"				, 0);
define( "PARAM_SECURITY"			, "p@RaM3tR0" );
define( "CRON"													, 0);





?>
