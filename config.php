<?php

define( "DOMAIN",  'guimpo.com') ;

define( "PATH_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/");

define( "PATH_ROOT_CLASES", PATH_ROOT ."/clases/");

define( "PATH_ROOT_CSS", "http://www.".DOMAIN."/css/" );

define( "PATH_ROOT_IMG", "http://www.".DOMAIN."/img/" );

define( "PATH_ROOT_MULTIMEDIA", "http://www.".DOMAIN."/multimedia/" );

define( "PATH_ROOT_UPLOADS", "http://www.".DOMAIN."/img/uploads/" );

define( "PATH_UPLOADS", PATH_ROOT ."img/uploads/" );

define( "PATH_ROOT_INCLUDES", "http://www.".DOMAIN."/includes/" );

define( "PATH_ROOT_JS", "http://www.".DOMAIN."/js/");

define( "PATH_ADMIN", PATH_ROOT ."admin/" );


define( "ENVIRONMENT",  'local') ;
define( "VERSION",  '1') ;

define( "IP_MEMCACHE", "172.26.0.7" );
define( "USE_MEMCACHE", 0);
define( "PARAM_SECURITY", "p@RaM3tR0" );
define( "CRON", 0);
define( "MAX_ITEMS", 12);

define( "EXPIRE_COOKIES_MSG",  600000) ;

define('LANGUAGES', 'es-ca-en');

define('DBDRIVER','mysql');
define('HOST', 'localhost');
define('PORT', '3306');
define('USER','root');
define('PASSWORD','root');
define('DBNAME','framework');

//mailing
define('SERVER_MAIL'    , "");
define('PORT_MAIL'      , 25);
define('USER_MAIL'      , "");
define('PASSWORD_MAIL'  , "");

?>
