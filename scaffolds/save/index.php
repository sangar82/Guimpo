<?php

require_once('../config.php'); 
require_once(PATH_ROOT_CLASES . 'cdatabase.php'); 
require_once(PATH_ROOT_CLASES . 'cutils.php'); 

$con = Conecta();

$tab = chr(9);
$sl  = chr(13);
$slht  = chr(13).chr(10);

$array_languages = Cutils::get_web_languages();
$sql_seq    =  '';
$sql_table  =  '';

$webform_relational = '

{
                "name"                  : "categoria_gallery",
                "type"                  : "webform_relational",
                "stripped"              : "name",
                "relation_stripped"     : true,
                "relation_multilang"    : false, 
                "campos"                : {
            
                            "name" : {                                        
                                        "class"         : "",
                                        "value"         : "",
                                        "mandatory"     : "1",
                                        "type"          : "text",
                                        "minlength"     : "1",
                                        "maxlength"     : "60",
                                        "size"          : "60", 
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : false
                                         },
                                        
                            "image" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "1",
                                        "type"       : "image",
                                        "minlength"  : "0",
                                        "maxlength"  : "200",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },

                            "categoria_id" : {                                        
                                        "class"      : "",
                                        "value"      : "relation_id",
                                        "mandatory"  : "1",
                                        "type"       : "hidden",
                                        "maxlength"  : "200"}
                          
                          }
             }

';



$webform = '{
                "name"        : "categoria",
                "type"        : "webform",
                "stripped"    : "name",
                "campos"      : {
            
                            "name" : {                                        
                                        "class"         : "",
                                        "value"         : "",
                                        "mandatory"     : "1",
                                        "type"          : "text",
                                        "minlength"     : "1",
                                        "maxlength"     : "60",
                                        "size"          : "60", 
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : false
                                         },
                                         
                            "descripcion" : {
                                        "class"         : "",
                                        "value"         : "",
                                        "mandatory"     : "0",
                                        "type"          : "textarea",
                                        "cols"          : "57",
                                        "rows"          : "8",
                                        "minlength"     : "0",
                                        "maxlength"     : "500",
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : true,
                                        "ckeditor"      : true}


                          }
             }';


/*
$webform = '{
                "name"        : "categoria",
                "type"        : "webform",
                "stripped"    : "name",
                "campos"      : {
            
                            "name" : {                                        
                                        "class"         : "",
                                        "value"         : "",
                                        "mandatory"     : "1",
                                        "type"          : "text",
                                        "minlength"     : "1",
                                        "maxlength"     : "60",
                                        "size"          : "60", 
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : false
                                         },

                            "cantidad" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "1",
                                        "type"       : "numeric",
                                        "minlength"  : "-4",
                                        "maxlength"  : "1000",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },
                                        
                                        
                            "publico" : {                                        
                                        "class"      : "",
                                        "value"      : "1",
                                        "mandatory"  : "0",
                                        "type"       : "checkbox",
                                        "checked"    : "false",
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },
                                        
                            "fecha" : {                                        
                                        "class"         : "datepicker",
                                        "value"         : "",
                                        "mandatory"     : "1",
                                        "type"          : "datepicker",
                                        "minlength"     : "1",
                                        "maxlength"     : "60",
                                        "size"          : "60", 
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : false
                                         },
                                        
                            "idioma" : {                                        
                                        "class"               : "",
                                        "mandatory"           : "1",
                                        "type"                : "select",
                                        "with_language"       : "0",
                                        "default_language"    : "es",
                                        "with_default_value"  : "1",
                                        "lng"                 : "es",
                                        "size"                : "1", 
                                        "multiple"            : "false", 
                                        "disabled"            : "false", 
                                        "readonly"            : "false",
                                        "tabindex"            : "0", 
                                        "options"             : {
                                                                "castellano" : {
                                                                              "text"      : "Castellano",                                        
                                                                              "selected"  : "true",
                                                                              "value"     : "castellano"
                                                                              }, 
                                                                        
                                                                "ingles" : {
                                                                              "text"      : "Ingles",                                        
                                                                              "selected"  : "false",
                                                                              "value"     : "ingles"
                                                                           }                                           
                                                                }
                                        }, 
                                                                               
                                        
            
                            "tipo" : {                                        
       
                                        "type"       : "radio",
                                        "mandatory"  : "0",
                                        "options"    : {
                                                        "masculino" : {
                                                                      "class"      : "",
                                                                      "value"      : "masculino",                                        
                                                                      "checked"    : "true",
                                                                      "disabled"   : "false", 
                                                                      "readonly"   : "false",
                                                                      "tabindex"   : "0"
                                                                      }, 
                                                                
                                                        "femenino" : {
                                                                      "class"      : "",
                                                                      "value"      : "femenino",
                                                                      "checked"    : "false",
                                                                      "disabled"   : "false", 
                                                                      "readonly"   : "false",
                                                                      "tabindex"   : "0"
                                                                      } 
                                                       }
                                        }, 
                                        
                            "descripcion" : {
                                        "class"         : "",
                                        "value"         : "",
                                        "mandatory"     : "0",
                                        "type"          : "textarea",
                                        "cols"          : "57",
                                        "rows"          : "8",
                                        "minlength"     : "0",
                                        "maxlength"     : "500",
                                        "disabled"      : "false", 
                                        "readonly"      : "false",
                                        "tabindex"      : "0",
                                        "multilanguage" : false
                                         },
                                        
                            "image" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "0",
                                        "type"       : "image",
                                        "minlength"  : "0",
                                        "maxlength"  : "200",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" },

                             "file" : {                                        
                                        "class"      : "",
                                        "value"      : "",
                                        "mandatory"  : "0",
                                        "extensions" : "pdf,doc",
                                        "type"       : "file",
                                        "minlength"  : "0",
                                        "maxlength"  : "200",
                                        "size"       : "60", 
                                        "disabled"   : "false", 
                                        "readonly"   : "false",
                                        "tabindex"   : "0" }
                          }
             }';

*/

//Recogemos las opciones
$toshow         = ( isset($_REQUEST['t']))              ?   $webform_relational          : $webform;
$scaffold       = ( isset($_REQUEST['scaffold']))       ?   $_REQUEST['scaffold']        : "";
$secuencia      = ( isset($_REQUEST['secuencia']))      ?   $_REQUEST['secuencia']       : "0";
$tabla          = ( isset($_REQUEST['tabla']))          ?   $_REQUEST['tabla']           : "0";
$droptabla      = ( isset($_REQUEST['droptabla']))      ?   $_REQUEST['droptabla']       : "0";
$htaccess       = ( isset($_REQUEST['htaccess']))       ?   $_REQUEST['htaccess']        : "0";
$admin          = ( isset($_REQUEST['admin']))          ?   $_REQUEST['admin']           : "0";
$frontend       = ( isset($_REQUEST['frontend']))       ?   $_REQUEST['frontend']        : "0";
$cambios        = ( isset($_REQUEST['cambios']))        ?   $_REQUEST['cambios']         : "0";


if ($scaffold == ""){
  
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

echo "<head>";

  echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
  echo "<meta http-equiv='expires' content='1200' />";
  echo "<meta http-equiv='content-language' content='es' />";
  echo "<link href='http://www.guimpo.com/css/styles.css?1' rel='stylesheet' type='text/css' />";
  echo "<link rel='stylesheet' href='http://www.guimpo.com/css/cupertino/jquery-ui-1.8.9.custom.css?1'>";
  echo "<script language='JavaScript' charset='UTF-8' src='http://www.guimpo.com/js/jquery.js?1'></script>";
  echo "<script src='http://www.guimpo.com/js/jquery-ui-1.8.9.custom.min.js?1'></script>";
  echo "<script>$(function() {\$('#examples').accordion({autoHeight: false,navigation: true, collapsible:true, active:false});});</script>";
  echo "<style>.ui-widget-content{font-size:12px;}</style>";
  
echo "</head>";

echo "<body>";

echo "<div  id='cont'>";
  
  echo "<h3>MVCgenerator</h3>";
  
  echo "<form method='POST'>";
  
    echo "<div style='width:1300px;height:auto;'>";
  
      echo "<textarea name='scaffold' cols='100' rows='40' style='float:left;'>$toshow</textarea>";
      
      echo "<div id='examples' style='width:300px;float:left;margin-left:30px;'>";
    ?>
    
<h3><a href="#">Text</a></h3>
<div>
<pre>
"name" : {
  "class"      : "",
  "value"      : "",
  "mandatory"  : "1",
  "type"       : "text",
  "minlength"  : "1",
  "maxlength"  : "60",
  "size"       : "60", 
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0" }
</pre>
</div>
	
<h3><a href="#">Textarea</a></h3>
<div>
<pre>
"descripcion" : {
  "class"      : "",
  "value"      : "",
  "mandatory"  : "0",
  "type"       : "textarea",
  "cols"       : "57",
  "rows"       : "8",
  "minlength"  : "0",
  "maxlength"  : "500",
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0" }
</pre>
</div>

<h3><a href="#">Textarea with CKeditor</a></h3>
<div>
<pre>
"descripcion" : {
  "class"         : "",
  "value"         : "",
  "mandatory"     : "0",
  "type"          : "textarea",
  "cols"          : "57",
  "rows"          : "8",
  "minlength"     : "0",
  "maxlength"     : "500",
  "disabled"      : "false", 
  "readonly"      : "false",
  "tabindex"      : "0",
  "multilanguage" : true,
  "ckeditor"      : true}
</pre>
</div>	
	
<h3><a href="#">Numeric</a></h3>
<div>
<pre>
"cantidad" : {
  "class"      : "",
  "value"      : "",
  "mandatory"  : "1",
  "type"       : "numeric",
  "minlength"  : "-4",
  "maxlength"  : "1000",
  "size"       : "60", 
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0" }
</pre>
</div>	
	
<h3><a href="#">Checkbox</a></h3>
<div>
<pre>
"publico" : {
  "class"      : "",
  "value"      : "1",
  "mandatory"  : "0",
  "type"       : "checkbox",
  "checked"    : "false",
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0"}

</pre>
</div>	
	
<h3><a href="#">Select</a></h3>
<div>
<pre>
"idioma" : {
  "class"               : "",
  "mandatory"           : "1",
  "type"                : "select",
  "with_language"       : "0",
  "default_language"    : "es",
  "with_default_value"  : "1",
  "lng"                 : "es",
  "size"                : "1", 
  "multiple"            : "false", 
  "disabled"            : "false", 
  "readonly"            : "false",
  "tabindex"            : "0", 
  "options"             : {
      "castellano" : {
        "text"      : "Castellano",                                        
        "selected"  : "true",
        "value"     : "castellano"}, 
      "ingles" : {
        "text"      : "Ingles",                                        
        "selected"  : "false",
        "value"     : "ingles"}
   }
}
</pre>
</div>	

<h3><a href="#">Select from BD</a></h3>
<div>
<pre>
"poblacion" : {                                        
  "class"               : "",
  "mandatory"           : "1",
  "type"                : "selectbd",
  "with_language"       : "0",
  "default_language"    : "es",
  "with_default_value"  : "1",
  "lng"                 : "es",
  "size"                : "1", 
  "multiple"            : "false", 
  "disabled"            : "false", 
  "readonly"            : "false",
  "tabindex"            : "0", 
  "options"             : {
    "table" : "poblaciones",
    "idshow":  "id",
    "nameshow": "poblacion",
    "queryoptions": "",
    "default":""}
} 
</pre>
</div>	
	
<h3><a href="#">Radio Buttons</a></h3>
<div>
<pre>
"tipo" : {
"type"       : "radio",
"mandatory"  : "0",
"options"    : {

  "masculino" : {
  "class"      : "",
  "value"      : "masculino",                                        
  "checked"    : "true",
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0"}, 
  
  "femenino" : {
  "class"      : "",
  "value"      : "femenino",
  "checked"    : "false",
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0"} 
  }
} 
</pre>
</div>	
	
<h3><a href="#">Upload an image</a></h3>
<div>
<pre>
"image" : {
  "class"      : "",
  "value"      : "",
  "mandatory"  : "0",
  "type"       : "image",
  "minlength"  : "0",
  "maxlength"  : "200",
  "size"       : "60", 
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0" }
</pre>
</div>	
	
<h3><a href="#">Upload a file</a></h3>
<div>
<pre>
"file" : {
  "class"      : "",
  "value"      : "",
  "mandatory"  : "0",
  "extensions" : "pdf,doc",
  "type"       : "file",
  "minlength"  : "0",
  "maxlength"  : "200",
  "size"       : "60", 
  "disabled"   : "false", 
  "readonly"   : "false",
  "tabindex"   : "0" }
</pre>
</div>
	
<h3><a href="#">Datepicker</a></h3>
<div>
<pre>
"fecha" : {
  "class"         : "datepicker",
  "value"         : "",
  "mandatory"     : "1",
  "type"          : "datepicker",
  "minlength"     : "1",
  "maxlength"     : "60",
  "size"          : "60", 
  "disabled"      : "false", 
  "readonly"      : "false",
  "tabindex"      : "0",
  "multilanguage" : false}
</pre>
</div>

<h3><a href="#">Hidden</a></h3>
<div>
<pre>
"post_id" : {
  "class"      : "",
  "value"      : "relation_id",
  "mandatory"  : "1",
  "type"       : "hidden",
  "maxlength"  : "200"}
</pre>
</div>
	
	
  
   <?php
      echo "</div>";
    
    echo "</div>";
    
    echo "<div style='clear:both;'></div>";
    
    echo "<div class='options'>";
    
      echo "<b>BD</b><input type='checkbox' name='secuencia' id='secuencia'> <label for='secuencia'>Crear secuencia</label>";
      
      echo "&nbsp;&nbsp; <input type='checkbox' name='tabla' id='tabla'> <label for='tabla'>Crear tabla</label>";
      
      echo "&nbsp;&nbsp; <input type='checkbox' name='droptabla' id='droptabla'> <label for='droptabla'>Drop tabla</label>";
      
      echo "<br><br><input type='checkbox' name='htaccess' id='htaccess'><label for='htaccess'>Modificar htaccess</label>";
      
      //echo "&nbsp;&nbsp;<input type='checkbox' name='frontend' id='frontend'><label for='frontend'>Crear en frontend</label>";
  
      echo "&nbsp;&nbsp;<input type='checkbox' name='cambios' id='cambios'><label for='cambios'>Cambios en el codigo</label>";
      
      echo "&nbsp;&nbsp;<input type='checkbox' name='admin' id='admin'><label for='admin'>Crear en admin</label>";
      
      echo "<br /><br /><input type='submit' value='Crear'>";
    
    echo "</div>";
    
  echo "</form>";
  
  echo "</div>";
  
  echo "</body>";
  
  echo "</html>";
  
  die();
  
}
 

if ( strpos($scaffold, '\\') ){
  $scaffold = str_replace("\\", "", $scaffold);
}


//Transformas el array en json en un array para tratarlo
$arrayjson = json_decode($scaffold, true);

if (!$arrayjson)
  die('No se ha podido convertir el array. Revisa los posibles errores de construcción del array JSON');


//***********************************/
//** * CREACION DE LA TABLA * *******/
//***********************************/

echo "<h3>MVCgenerator</h3>";

if ($secuencia or $tabla)
  echo "<b>Base de datos</b><br/>";

if (DBDRIVER == "postgresql"){  
	
	if ( $secuencia ){
		
		$sql_seq = "CREATE SEQUENCE ".$arrayjson['name']."_seq;";
		
		$result = @pg_query($con, $sql_seq);
		
		if ($result){
		  echo "<font color='green'> &rArr; </font> Secuencia creada con &eacute;xito <br />";
		}else{
		  echo "<font color='red'> &rArr; </font> La secuencia ya estaba creada <br />";
		}
		  
	}

}


if (DBDRIVER == "postgresql"){  
  
  
  $sql_table = "";
  
  if ($droptabla)
    $sql_table .= "DROP TABLE ".$arrayjson['name']."; "; 
  
  $sql_table .= "CREATE TABLE ".$arrayjson['name']." ("; 
  $sql_table .= "id integer DEFAULT nextval('".$arrayjson['name']."_seq'::regclass) NOT NULL,";
}else if (DBDRIVER == "mysql"){
  $sql_table = "CREATE TABLE ".$arrayjson['name']." ("; 
  $sql_table .= "id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,";
}

foreach ($arrayjson['campos'] as $index => $value ){
  
  switch ($value['type']){
    
    case 'text':
      
        if ( $value['multilanguage']){
          
          $sql_table_aux = '';
          
          foreach ($array_languages as $item ) {
          	
            if (DBDRIVER == "postgresql"){  
              $sql_table_aux .= $index."_".$item ." character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
            }else if (DBDRIVER == "mysql"){
              $sql_table_aux .= $index."_".$item ." varchar(".$value['maxlength'].") DEFAULT '' "; 
            }
          
            if ($value['mandatory'])
             $sql_table_aux .= "NOT NULL, ";
            else 
              $sql_table_aux .= ", ";
            
          }
          
          $sql_table .= $sql_table_aux;

          
        } else {
        
          if (DBDRIVER == "postgresql"){  
            $sql_table .= $index." character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
          }else if (DBDRIVER == "mysql"){
            $sql_table .= $index."  varchar(".$value['maxlength'].")  DEFAULT '' ";
          }
            
            
          if ($value['mandatory'])
           $sql_table .= "NOT NULL, ";
          else 
            $sql_table .= ", ";
          
        }
        
           
        break;
        
    case 'datepicker':
      
        if (DBDRIVER == "postgresql"){  
          $sql_table .= $index." date , ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index."  date , ";
        }
      
      break;    

    case 'image':
    case 'file':
        
        if (DBDRIVER == "postgresql"){  
          $sql_table .= $index." character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index."  varchar(".$value['maxlength'].")  DEFAULT '' ";
        }
        
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
        break;
    
    case 'textarea':
      
        if ( $value['multilanguage']){
         
          $sql_table_aux = '';
       
          
          foreach ($array_languages as $item ) {
            
            $sql_table_aux .= $index."_".$item ." text  ";
          
            if ($value['mandatory'])
             $sql_table_aux .= "NOT NULL, ";
            else 
              $sql_table_aux .= ", ";
            
            
          }
          
          $sql_table .= $sql_table_aux;
          
        } else {
          
          $sql_table .= $index." text  ";
          
          if ($value['mandatory'])
           $sql_table .= "NOT NULL, ";
          else 
            $sql_table .= ", ";
        
          
        }
        
        break; 
           
    case 'numeric':
        
        if (DBDRIVER == "postgresql"){  
         $sql_table .= $index." integer ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index." INT(9) ";
        }
        
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
        break;
        
    case 'radio':
        
        if (DBDRIVER == "postgresql"){  
          $sql_table .= $index." character varying(50) ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index." VARCHAR(50) ";
        }
        
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
        break;
        
    case 'select':
    case 'selectbd':
        
        if (DBDRIVER == "postgresql"){  
          $sql_table .= $index." character varying(50) ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index." VARCHAR(50) ";
        }
        
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
        break;
        
    case 'checkbox':
        
        if (DBDRIVER == "postgresql"){  
         $sql_table .= $index." integer ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index." INT(9) ";
        }
        
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
        break;
        
    case 'hidden':
      
        if (DBDRIVER == "postgresql"){  
          $sql_table .= $index." character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
        }else if (DBDRIVER == "mysql"){
          $sql_table .= $index."  varchar(".$value['maxlength'].")  DEFAULT '' ";
        }
          
          
        if ($value['mandatory'])
         $sql_table .= "NOT NULL, ";
        else 
          $sql_table .= ", ";
          
      break;
    
  }

}


// Creamos en la bd los strippeds por idiomas

if ( isset($arrayjson['stripped']) ) {
  
  $sql_table_aux = '';
  
  if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
    
    foreach ($array_languages as $item ) {
    	
      if (DBDRIVER == "postgresql"){  
        $sql_table_aux .=  "stripped_".$item ." character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
      }else if (DBDRIVER == "mysql"){
        $sql_table_aux .=   "stripped_".$item ." varchar(".$value['maxlength'].")  DEFAULT '' ";
      }
      
      if ($value['mandatory'])
       $sql_table_aux .= "NOT NULL, ";
      else 
        $sql_table_aux .= ", ";
      
    }
    
    $sql_table .= $sql_table_aux; 
    
  }else{
    

    if (DBDRIVER == "postgresql"){  
      $sql_table .=  "stripped  character varying(".$value['maxlength'].") DEFAULT ''::character varying ";
    }else if (DBDRIVER == "mysql"){
      $sql_table .=   "stripped varchar(".$value['maxlength'].")  DEFAULT '' ";
    }    
    
    
    if ($value['mandatory'])
     $sql_table .= "NOT NULL, ";
    else 
      $sql_table .= ", ";
    
  }
 
}

if (DBDRIVER == "postgresql"){  
  $sql_table .= "created timestamp without time zone DEFAULT now() NOT NULL,";
  $sql_table .= "updated timestamp without time zone DEFAULT now() NOT NULL";
}else if (DBDRIVER == "mysql"){
  $sql_table .= "created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,";
  $sql_table .= "updated TIMESTAMP NOT NULL";
}

$sql_table .= ");";


if ( $tabla ){
  
  if (DBDRIVER == "postgresql"){
    $result = pg_query($con, $sql_table);
  }else if (DBDRIVER == "mysql"){
    $result = mysql_query($sql_table);
  }
  
  if ($result){
    
    //contamos el numero de migraciones
    $archivos =  glob(PATH_ROOT."/bd/migrations/{migration_*}",GLOB_BRACE);
    
    $total = count($archivos);
    
    $nmig = ((int)$total < 9) ? "0".((int)$total+1) : (int)$total+1;
    
    //Guardamos la migración
      $archivo=fopen("../bd/migrations/migration_".$nmig."_".$arrayjson['name'].".sql" , "a");
    if ($archivo) {
      $result = fputs ($archivo, $sql_table);
    }
    fclose ($archivo);
    
    echo "<font color='green'> &rArr; </font>Tabla creada con &eacute;xito (migraci&oacute;n creada en /bd/migrations/migration_".$nmig."_".$arrayjson['name'].".sql) <br />";

    
  }else{
    echo "<font color='red'> &rArr; </font>Error creando la tabla <br />". mysql_error()."<br>".$sql_table."<br>";
  }
  
}



//***********************************/
//** * FIN CREACION DE LA TABLA * ***/
//***********************************/





//***********************************/
//** * CREACION DEL MODELO * ********/
//***********************************/

echo "<br/><b>Modelo</b> </br>";

$text = "<?php ". $sl;

//Adjuntamos archivos
//$text .= "require_once('config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cdatabase.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cimagen.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpaginado.php'); $sl $sl";

//definimos el nombbre de la clase
$text .=  "class C".$arrayjson['name']." { ".$sl;

  //creamos los atribuos
  $text .= $tab."var \$m_id; ".$sl;
  $text .= $tab."var \$m_name_stripped; ".$sl;
  $text .= $tab."var \$m_multilanguage; ".$sl;
  $text .= $tab."var \$m_type; ".$sl;
  
  foreach ($arrayjson['campos'] as $index => $value ){
    
    switch ($value['type']){
      
      case 'text':
      case 'textarea':
        
        if ( $value['multilanguage']){
           
          $aux = '';
          
          foreach ($array_languages as $item ) {
            
            $aux .= $tab."var \$m_" .$index."_".$item."; ".$sl;
            
          }
          
          $text .= $aux;
           
          
        } else {
           $text .= $tab."var \$m_" .$index ."; ".$sl;
        }
        
        break;
      
      default:
        
        $text .= $tab."var \$m_" .$index ."; ".$sl;
        break;
        
    }
       
  }
  
    //Añadimos el stripped si lo hubiera a los atributos
    if ( isset($arrayjson['stripped'] ) ) {
      
        if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
    
          
          foreach ($array_languages as $item ) {
          	
            $text .= $tab."var \$m_stripped_".$item ."; ".$sl;
            
          }
          
          }else{
            
            $text .= $tab."var \$m_stripped; $sl ";
          
        } 
      
    }
  
    //Creamos el constructor
    $text .= $sl.$tab."function C".$arrayjson['name']."(";
    $text .= " \$id = '', ";
    
    $is_multilanguage = false;
    
    //Creamos los parametros de la funcion del constructor
    foreach ($arrayjson['campos'] as $index => $value ){
      
      switch ($value['type']){
        
        case 'text':
        case 'textarea':
          
          if ( $value['multilanguage']){
           
            $aux = '';
            
            foreach ($array_languages as $item ) {
              $aux .= "\$" .$index ."_".$item." = '', ";
            }
            
            $text .= $aux;
            
            if ( isset($arrayjson['stripped'] ) ) {
              if ($arrayjson['stripped'] == $index)
                $is_multilanguage = true;
            }
            
          
          } else {
            $text .= "\$" .$index ." = '', ";
          }
          
         
          break;
        
        default:
          
          $text .= "\$" .$index ." = '', ";
          break;
        
      }
      
    }
    
    $text = substr( $text, 0, -2 );
    
    
    $text .= "){ $sl $sl ";
    
    if ( isset($arrayjson['stripped'] ) ) {
      $text .= $tab.$tab."\$this->m_name_stripped $tab = $tab '".$arrayjson['stripped']."'; ".$sl;
    }else{
      $text .= $tab.$tab."\$this->m_name_stripped $tab = $tab ''; ".$sl;
    }
    
    if ($is_multilanguage ) {
      $text .= $sl.$tab.$tab."\$this->m_multilanguage $tab = $tab true; ".$sl;
    }else{
      $text .= $sl.$tab.$tab."\$this->m_multilanguage $tab = $tab false; ".$sl;
    }
    
    if ( $arrayjson['type'] == 'webform_relational')  {
      $text .= $sl.$tab.$tab."\$this->m_type $tab = $tab 'webform_relational'; ".$sl;
    } else if ( $arrayjson['type'] == 'webform'){
      $text .= $sl.$tab.$tab."\$this->m_type $tab = $tab 'webform'; ".$sl;
    }
    
    //Constructor caso $id = ''
    
    $text .= $sl.$sl.$tab.$tab."if (\$id == ''){".$sl;
  
    foreach ($arrayjson['campos'] as $index => $value ){
      
      switch ($value['type']){
        
        case 'text':
        case 'textarea':
          
          if ( $value['multilanguage']){
            
            foreach ($array_languages as $item ) {
              $text .= $sl.$tab.$tab.$tab."\$this->m_".$index."_".$item.$tab."= \$".$index."_".$item.";" ;
            }
            
          } else {
            $text .= $sl.$tab.$tab.$tab."\$this->m_".$index .$tab."= \$".$index.";" ;
          }
          
          break;
          
                  
        default :
          
          $text .= $sl.$tab.$tab.$tab."\$this->m_".$index .$tab."= \$".$index.";" ;
          break;
      }
      
    }
    
        //Añadimos el stripped al constructor acabar
    if ( isset($arrayjson['stripped'] ) ) {
      
        if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
    
          
          foreach ($array_languages as $item ) {
          	
            $text .= $sl.$tab.$tab.$tab."\$this->m_stripped_".$item ." = Cutils::to_stripped(\$this->m_".$arrayjson['stripped']."_".$item."); ";
            
          }
          
          }else{
            
            $text .= $sl.$tab.$tab.$tab."\$this->m_stripped =  Cutils::to_stripped(\$this->m_".$arrayjson['stripped']."); ";
          
        } 
      
    }
    
    $text .= $sl.$sl.$tab.$tab."}else{" . $sl;
    
    $text .= $sl.$sl.$tab.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
    
    
    
    
    
    //Creamos la query para obtener el item
    $textaux = $sl.$tab.$tab.$tab."\$query = \"SELECT id, ";
    
    foreach ($arrayjson['campos'] as $index => $value ){
      
      switch ($value['type']){
        
        case 'text':
        case 'textarea':
          
          if ( $value['multilanguage']){
            
          
            foreach ($array_languages as $item ) {
              
               $textaux .= $index."_".$item.", "; 
            }
            
          } else {
             $textaux .= "$index, "; 
          }
          
          break;
          
        default:
          
          $textaux .= "$index, ";
          break;
        
      }
     
    }
    
    //Añadimos el stripped al sql del constructor
    if ( isset($arrayjson['stripped'] ) ) {
      
        if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
    
          
          foreach ($array_languages as $item ) {
          	
            $textaux .= "stripped_".$item.", ";
            
          }
          
          }else{
            
            $textaux .= "stripped, ";
          
        } 
      
    }
    
    
    
    $textaux .= "created, updated FROM ".$arrayjson['name']." WHERE id=\$id \";";
    
    $text .= $textaux;
    
    
    $text .= $sl.$sl.$tab.$tab.$tab."\$item = \$con->fetch_one_result(\$query);".$sl;
    
    $text .= $sl.$sl.$tab.$tab.$tab."if (\$item){";
    
    $text .= $sl.$sl.$tab.$tab.$tab.$tab."\$this->m_id 	 = \$item['id'];";
    
    foreach ($arrayjson['campos'] as $index => $value ){
      
      switch ($value['type']){
      
        case 'text':
        case 'textarea':
          
          if ( $value['multilanguage']){
            
            foreach ($array_languages as $item ) {
              $text .= $sl.$tab.$tab.$tab.$tab."\$this->m_".$index."_".$item.$tab."= \$item['".$index."_".$item."'];" ;
            }
            
          } else {
            $text .= $sl.$tab.$tab.$tab.$tab."\$this->m_".$index .$tab."= \$item['".$index."'];" ;
          }
          
          break;
          
        
        default:
          
          $text .= $sl.$tab.$tab.$tab.$tab."\$this->m_".$index .$tab."= \$item['".$index."'];" ;
          break;
          
      }
      
      
    }
    
    //Añadimos el stripped al constructor 
    if ( isset( $arrayjson['stripped'] ) ) {
      
        if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
    
          
          foreach ($array_languages as $item ) {
          	
            $text .= $sl.$tab.$tab.$tab.$tab."\$this->m_stripped_".$item ."$tab = \$item['stripped_".$item ."']; ";
            
          }
          
          }else{
            
            $text .= $sl.$tab.$tab.$tab.$tab."\$this->m_stripped $tab = \$item['stripped']; ";
          
        } 
      
    }
    
    $text .= $sl.$sl.$tab.$tab.$tab."}else{";
    $text .= $sl.$sl.$tab.$tab.$tab.$tab."\$this->m_id = null;";
    $text .= $sl.$sl.$tab.$tab.$tab."}";
    
    //Fin else constructor
    $text .= $sl.$tab.$tab."}" . $sl;
    
    //Fin constructor
    $text .= $sl.$tab."}" . $sl;
    
    
    //METODO SAVE
    
    $text .= $sl.$tab."function save(){".$sl;
    
    $text .= $tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
    
    //Construimos la query del save
    $text .=  $sl.$tab.$tab."\$sql = \"INSERT INTO ".$arrayjson['name']." (";
    
      foreach ($arrayjson['campos'] as $index => $value ){
        
        switch ($value['type']){

        case 'text':
        case 'textarea':
          
          $aux = '';
          
          if ( $value['multilanguage']){
            
            foreach ($array_languages as $item ) {
              $aux .= $index."_".$item.", ";
            }
            
          } else {
            $aux .= "$index, ";
          }
          
          $text .= $aux;

          break;

        default:

          $text .= "$index, ";
          break;         
          
        }
        
      }
      
      
      //Añadimos el stripped al sql del constructor
      if ( isset( $arrayjson['stripped']  ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
            
            foreach ($array_languages as $item ) {
            	
              $text .= "stripped_".$item.", ";
              
            }
            
            }else{
              
              $text .= "stripped, ";
            
          } 
        
      }
      
      $text = substr( $text, 0, -2 );
      
      $text .= ") VALUES (";
      
      foreach ($arrayjson['campos'] as $index => $value ){
        
        switch ($value['type']){
          
          case 'text':
          case 'textarea':
            
            $aux = '';
          
            if ( $value['multilanguage']){
            
              foreach ($array_languages as $item ) {
                $aux .=  "'\". \$this->m_".$index ."_".$item." .\"', " ;
              }
              
            } else {
              $aux .=  "'\". \$this->m_".$index ." .\"', " ;
            }
            
            $text .= $aux;
            
            break;
          
          case 'numeric':  
          case 'checkbox':
            
            $text .=  "\". \$this->m_".$index ." .\", " ;
            break;
              
            
          default:
            
            $text .=  "'\". \$this->m_".$index ." .\"', " ;
            break;
          
          
        }
        /* ojoooo
        if ($value['type'] != "numeric" and $value['type'] != "checkbox")
          $text .=  "'\". \$this->m_".$index ." .\"', " ;
        else 
          $text .=  "\". \$this->m_".$index ." .\", " ;
          
        */  
        
      }
      
      //Añadimos el stripped al sql del constructor
      if ( isset( $arrayjson['stripped'] ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
            
            foreach ($array_languages as $item ) {
            
              $text .=  "'\". \$this->m_stripped_".$item ." .\"', " ;
              
            }
            
            }else{
              
              $text .= " '\".\$this->m_stripped.\"', ";
            
          } 
        
      }
    
    $text = substr( $text, 0, -2 );
    
    $text .= ")\";".$sl;
      
    $text .= $tab.$tab."\$result = \$con->insert( \$sql );".$sl.$sl;
    
    $text .= $tab.$tab."if (\$result)".$sl;
      $text .= $tab.$tab.$tab."return true; ".$sl;
    $text .= $tab.$tab."else ".$sl;
      $text .= $tab.$tab.$tab."return false;";
    
    $text .= $sl.$tab."}".$sl.$sl;  //Fi save
    
    //FI METODO SAVE
    
    
    //METODO EDIT
    $text .= $sl.$tab."function edit(";
    
    foreach ($arrayjson['campos'] as $index => $value ){
       
     switch ($value['type']){

      case 'text':
      case 'textarea':
        
        $aux = '';
        
        if ( $value['multilanguage']){
          
          foreach ($array_languages as $item ) {
            $text .= "\$".$index."_".$item." = '', ";
          }
          
        } else {
          $text .= "\$" .$index ." = '', ";
        }
        
        break;
        
      default:
        
        $text .= "\$" .$index ." = '', ";
        break;
        
      }
      
    }
    
    $text = substr( $text, 0, -2 );
    
    $text .= "){".$sl;
    
      $text .= $tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
      
      $text .= $sl.$tab.$tab."\$query = \"UPDATE ".$arrayjson['name']." SET \"; ";
      
      
       foreach ($arrayjson['campos'] as $index => $value ){
           
         switch ($value['type']){
    
          case 'text':
          case 'textarea':
            
            $aux = '';
            
            if ( $value['multilanguage']){
              
              foreach ($array_languages as $item ) {
                
                if ($value['mandatory'])
                  $text .= $sl.$tab.$tab."\$query .= (\$".$index."_".$item." !== '') $tab ? \" ".$index."_".$item."='\$".$index."_".$item."', \" : \"\" ;";
                else 
                  $text .= $sl.$tab.$tab."\$query .= \"".$index."_".$item."='\$".$index."_".$item."', \"  ;";  
                  
              }
              
            } else {
              
              if ($value['mandatory'])
                $text .= $sl.$tab.$tab."\$query .= (\$".$index." !== '') $tab ? \"$index='\$$index', \" : \"\" ;";
              else 
                $text .= $sl.$tab.$tab."\$query .= \"$index='\$$index', \"  ;";  
                
            }
            
            break;
            
          case 'numeric':
          case 'checkbox':
            
            $text .= $sl.$tab.$tab."\$query .= (\$".$index." !== '') $tab ? \"$index=\$$index, \" : \"\" ;";
            break;
            
          case 'image':
            
            $text .= $sl.$tab.$tab."\$query .= (\$".$index." !== '') $tab ? \"$index='\$$index', \" : \"\" ;";
            break;
            
          default:
            
            if ($value['mandatory'])
              $text .= $sl.$tab.$tab."\$query .= (\$".$index." !== '') $tab ? \"$index='\$$index', \" : \"\" ;";
            else 
              $text .= $sl.$tab.$tab."\$query .= \"$index='\$$index', \"  ;";  
              
            break;
         }
 
      }
      
      //Añadimos el stripped al edit
      if ( isset( $arrayjson['stripped'] ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
        
            
            foreach ($array_languages as $item ) {
              
              $text .= $sl.$tab.$tab."\$query .= (\$".$arrayjson['stripped']."_$item !== '') 	 ? \"stripped_".$item."='\".Cutils::to_stripped(\$".$arrayjson['stripped']."_".$item.").\"' ,\" : \"\" ;   ";
            }
            
         	}else{
              
              $text .= $sl.$tab.$tab."\$query .= (\$".$arrayjson['stripped']." !== '') 	 ? \"stripped='\".Cutils::to_stripped(\$".$arrayjson['stripped'].").\"' ,\" : \"\" ;   ";
            
          } 
        
      }
      
      $text .= $sl.$tab.$tab."\$query .= \" updated=now()\";";
      
      $text .= $sl.$tab.$tab."\$query .= \" WHERE id=\".\$this->m_id.\"; \";";
		
		  $text .= $sl.$sl.$tab.$tab."\$result = \$con->update(\$query);";
  		
      $text .= $sl.$sl.$tab.$tab."if (\$result)".$sl;
        $text .= $tab.$tab.$tab."return true; ".$sl;
      $text .= $tab.$tab."else ".$sl;
        $text .= $tab.$tab.$tab."return false;";
      
      
    $text .= $sl.$tab."}".$sl.$sl;  //Fi edit
    
    //FI METODO EDIT
    
    
    //METODO DELETE
    
    $text .= $sl.$tab."function delete(){".$sl;
    
      $text .= $tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
      
      $text .= $sl.$sl.$tab.$tab."\$item = \$this->load_item_to_array(); ";
      
      //Construimos la query del save
      $text .=  $sl.$sl.$tab.$tab."\$sql = \"DELETE from ".$arrayjson['name']." WHERE id=\".\$this->m_id.\"; \";";
      
      $text.= $sl.$tab.$tab."\$result = \$con->delete(\$sql);";
      
      
      $text .= $sl.$sl.$tab.$tab."if (\$result){".$sl;
        
        //Si existe tipo imagen borramos la imagen subida
        foreach ($arrayjson['campos'] as $index => $value ){
	    
	         switch ($value['type']){
	         
	           case 'image':
	             
	             $text .= $sl.$sl.$tab.$tab.$tab."//Borramos la imagen i los thumbs";
               $text .= $sl.$tab.$tab.$tab."Cimagen::delete(\$item['image']); ";
	             break;
	             
	           
	           case 'file':  
	             $text .= $sl.$sl.$tab.$tab.$tab."//Borramos el archivo";
               $text .= $sl.$tab.$tab.$tab."Carchivo::delete(\$item['file']); ";
	           break;
	             
	         }
	           
	       }
	       
        $text .= $sl.$sl.$tab.$tab.$tab."return true; ".$sl;
        
      $text .= $tab.$tab."}else ".$sl;
        $text .= $tab.$tab.$tab."return false;";
    
    $text .= $sl.$tab."}".$sl.$sl;  //Fi delete
    
    //FI METODO DELETE
    
    
    // LOAD ITEM TO ARRAY
    $text .= $sl.$tab."function load_item_to_array(){".$sl;
    
      $text .= $tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
      
      //Creamos la query para obtener el item
      $text .=  $sl.$tab.$tab."\$query = \"SELECT id, ";
      foreach ($arrayjson['campos'] as $index => $value ){
        
        switch ($value['type']){
        
          case 'text':
          case 'textarea':
            
            $aux = '';
            
            if ( $value['multilanguage']){
              
              foreach ($array_languages as $item ) {
                $aux .= $index."_".$item.", ";
              }
              
            } else {
              $aux .= "$index, ";
            }
            
            $text .= $aux;
            
            break;
            
          default:
            
            $text .= "$index, ";
            break;
            
        }
         
      }
      
      //Añadimos el stripped al sql del constructor
      if ( isset( $arrayjson['stripped']  ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
            
            foreach ($array_languages as $item ) {
            	
              $text .= "stripped_".$item.", ";
              
            }
            
            }else{
              
              $text .= "stripped, ";
            
          } 
        
      }
      
      $text .= "created, updated FROM ".$arrayjson['name']." WHERE id=\".\$this->m_id.\" ;\";";
      
      $text .= $sl.$tab.$tab."\$item = \$con->fetch_one_result(\$query);".$sl;
      
      $text .= $sl.$tab.$tab."if (\$item == 0 || \$item == -2)".$sl; 
        $text .= $tab.$tab.$tab."return false; ".$sl;
      $text .= $tab.$tab."else ".$sl;
        $text .= $tab.$tab.$tab."return \$item;";
      
    $text .= $sl.$tab."}".$sl.$sl;  //Fi delete
    
    // FI LOAD ITEM TO ARRAY
    
    
    // ITEM LIST
    if ( $arrayjson['type'] == 'webform_relational')  {
      $text .= $sl.$tab."static function item_list(\$id = '' , \$max = '', \$pag = 1){".$sl;
    } else if ( $arrayjson['type'] == 'webform'){
      $text .= $sl.$tab."static function item_list(\$max = '', \$pag = 1){".$sl;
    }
    
      $text .= $tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;

      $text .= $sl.$tab.$tab."\$max_rows = '';".$sl;
      
      //Creamos la query para obtener el item
      $text .=  $sl.$tab.$tab."\$query = \"SELECT id, ";
      
      foreach ($arrayjson['campos'] as $index => $value ){
        
        switch ($value['type']){
        
          case 'text':
          case 'textarea':
            
            $aux = '';
            
            if ( $value['multilanguage']){
              
              foreach ($array_languages as $item ) {
                $aux .= $index."_".$item.", ";
              }
              
            } else {
              $aux .= "$index, ";
            }
            
            $text .= $aux;
            
            break;
            
          default:
            
            $text .= "$index, ";
            break;
            
        }
        
      }
      
      //Añadimos el stripped al sql 
      if ( isset( $arrayjson['stripped'] ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
            
            foreach ($array_languages as $item ) {
            	
              $text .= "stripped_".$item.", ";
              
            }
            
            }else{
              
              $text .= "stripped, ";
            
          } 
        
      }
      
      $text .= "created, updated FROM ".$arrayjson['name']." ";
      
      if ( $arrayjson['type'] == 'webform_relational')  {
        //recogemos el nombre del item al que hace referencia la galeria para recoger los parametros ke envia
        $relation = split("_",$arrayjson['name']);
        $name_of_relation = $relation[0];  
        $name_of_this = $relation[1];  
      
        $text .= "WHERE ".$name_of_relation."_id = \$id ";
      }
      
      $text .= "ORDER BY id desc \";";
       
      $text .= $sl.$tab.$tab."if (\$max!='' && \$max>0){";
      
        $text .= $sl.$sl.$tab.$tab.$tab."\$offset = (\$pag - 1) * \$max;";
        
        if ( $arrayjson['type'] == 'webform_relational')  {
          $text .= $sl.$sl.$tab.$tab.$tab."\$query_max = \"SELECT count(id) as max FROM ".$arrayjson['name']." WHERE ".$name_of_relation."_id =\$id \"; ";
        }else{
          $text .= $sl.$sl.$tab.$tab.$tab."\$query_max = \"SELECT count(id) as max FROM ".$arrayjson['name']."\"; ";
        }
        
        $text .= $sl.$tab.$tab.$tab."\$result_max = \$con->fetch_one_result(\$query_max);";
        
        $text .= $sl.$sl.$tab.$tab.$tab."\$max_rows = (\$result_max) ? \$result_max['max'] : '';";
        
        $text .= $sl.$sl.$tab.$tab.$tab."if (\$offset > \$max_rows) \$offset = 0;";
        
        $text .= $sl.$sl.$tab.$tab.$tab."\$query .= \" LIMIT \$max OFFSET \$offset \"; ";
      
      $text .= $sl.$sl.$tab.$tab."}";
      
      $text .= $sl.$sl.$tab.$tab."\$item = \$con->fetch_array(\$query);";
      
      $text .= $sl.$sl.$tab.$tab."if (\$max_rows == ''){ ";
        $text .= $sl.$tab.$tab.$tab."\$max_rows = count(\$item);";
      $text .= $sl.$tab.$tab."}";
      
      
      $text .= $sl.$sl.$tab.$tab."if (\$item)".$sl;
        $text .= $tab.$tab.$tab."return array('item' => \$item, 'total' => \$max_rows);".$sl;
      $text .= $tab.$tab."else ".$sl;
        $text .= $tab.$tab.$tab."return false;";
    
    $text .= $sl.$tab."}".$sl.$sl;  //Fi delete
    // FI ITEM LIST
    
    
    //
    
    if ( $arrayjson['type'] == 'webform_relational')  {
      
       $text .= $sl.$sl.$tab."static function count_".$arrayjson['name']."(\$".$name_of_relation."_id){".$sl;
       
       $text .= $sl.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );";

       $text .= $sl.$sl.$tab.$tab."\$query = \"SELECT count(id) as counter FROM ".$arrayjson['name']." WHERE ".$name_of_relation."_id = \$".$name_of_relation."_id\"; ";
       $text .= $sl.$tab.$tab."\$result = \$con->fetch_one_result(\$query);";
       
       $text .= $sl.$sl.$tab.$tab."if (\$result)";
       $text .= $sl.$tab.$tab.$tab."return \$result['counter']; ";
       $text .= $sl.$tab.$tab."else";
       $text .= $sl.$tab.$tab.$tab."return false; ";
       
       
       $text .= $sl.$tab."}".$sl.$sl;  //Fi 
    }
    
    
    
    //EXISTS
    $text .= $sl.$sl.$tab."function exists(){".$sl;
    
      $text .= $sl.$tab.$tab."if (\$this->m_id != null)";
      $text .= $sl.$tab.$tab.$tab."return true; ";
      $text .= $sl.$tab.$tab."else";
      $text .= $sl.$tab.$tab.$tab."return false; ";
    
    $text .= $sl.$tab."}".$sl;
   
    //FI EXISTS
    

    
    //get_id_from_stripped
    if ( isset( $arrayjson['stripped'] ) ) {
    
      $text .= $sl.$sl.$tab."static function get_id_from_stripped(\$stripped){";
      
      $text .= $sl.$sl.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );".$sl;
      
      $text .= $sl.$tab.$tab."\$lng = Cutils::get_actual_lng();";
      
      $text .= $sl.$tab.$tab."\$query = \"SELECT id FROM ".$arrayjson['name']." WHERE ";
      
          
      if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
  
        $text .= "stripped_\$lng ='\$stripped'; \"; ";
          
      }else{
          
        $text .= "stripped='\$stripped'; \"; ";
        
      }
      
      $text .= $sl.$sl.$tab.$tab."\$item = \$con->fetch_one_result(\$query);";
      
      $text .= $sl.$sl.$tab.$tab."if (\$item)";
      $text .= $sl.$tab.$tab.$tab."return \$item['id']; ";
      $text .= $sl.$tab.$tab."else";
      $text .= $sl.$tab.$tab.$tab."return false; ";
      
      $text .= $sl.$sl.$sl.$tab."}";
  
    }
    
    //htmlentities(stripslashes($_REQUEST[$name_obj]),ENT_QUOTES, 'UTF-8')
    //Creamos un metodo dependiendo del tipo y segun los casos de striped y lenguajes
    if ( isset($arrayjson['stripped'] ) ) {
      
      if ($is_multilanguage ) {
        
        if ( $arrayjson['type'] == 'webform')  {
          
          $text .= $sl.$sl.$sl.$tab."function is_unique(";
          
          foreach ($array_languages as $item ) {
            $text .= "\$stripped_".$item.", ";
          }
          
          $text = substr( $text, 0, -2 );  
              
           $text .= "){";
          
           $text .= $sl.$sl.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER ); ";
           
           $text .= $sl.$sl.$tab.$tab."\$lng = Cutils::get_actual_lng();";
           
           $text .= $sl.$tab.$tab."\$query = \"SELECT  * FROM ".$arrayjson['name']." WHERE ";
           
           foreach ($array_languages as $item ) {
            $text .= "stripped_".$item." = '\".Cutils::to_stripped(\$stripped_".$item.").\"' or ";
           }
           
           $text = substr( $text, 0, -4 ); 
           $text.="\";";      

          
        } else if ( $arrayjson['type'] == 'webform_relational')  {
         
            $text .= $sl.$sl.$sl.$tab."function is_unique(";
            
            foreach ($array_languages as $item ) {
              $text .= "\$stripped_".$item.", ";
            }
            
              
           $text .= "\$relation_id){";
          
           $text .= $sl.$sl.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER ); ";
           
           $text .= $sl.$sl.$tab.$tab."\$lng = Cutils::get_actual_lng();";
           
           $text .= $sl.$tab.$tab."\$query = \"SELECT  * FROM ".$arrayjson['name']." WHERE ";
           
           foreach ($array_languages as $item ) {
            $text .= "stripped_".$item." = '\".Cutils::to_stripped(\$stripped_".$item.").\"' or ";
           }
           
           $text = substr( $text, 0, -4 ) ." and ".$name_of_relation."_id=\$relation_id;"; 
           $text.="\";";      
           
              
        }

        
      }else{
        
        if ( $arrayjson['type'] == 'webform')  {
          
          $text .= $sl.$sl.$sl.$tab."function is_unique(\$stripped){";
          
           $text .= $sl.$sl.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER ); ";
           
           $text .= $sl.$tab.$tab."\$query = \"SELECT * FROM ".$arrayjson['name']." WHERE stripped = '\".Cutils::to_stripped(\$stripped).\"' ;\"; ";
          
          
        } else if ( $arrayjson['type'] == 'webform_relational')  {
          
           $text .= $sl.$sl.$sl.$tab."function is_unique(\$stripped, \$relation_id){";
          
            $text .= $sl.$sl.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER ); ";
           
            $text .= $sl.$tab.$tab."\$query = \"SELECT * FROM ".$arrayjson['name']." WHERE stripped = '\".Cutils::to_stripped(\$stripped).\"' and ".$name_of_relation."_id = \$relation_id   ;\"; ";
        }
        
      }
      
      
      $text .= $sl.$sl.$tab.$tab."\$item = \$con->fetch_one_result(\$query);";
      
      $text .= $sl.$sl.$tab.$tab."if (\$item)";
      $text .= $sl.$tab.$tab.$tab."return false; ";
      $text .= $sl.$tab.$tab."else";
      $text .= $sl.$tab.$tab.$tab."return true; ";
      
      $text .= $sl.$sl.$sl.$tab."}";
          
    }
    
    //Get strippeds para cambios de idiomas
    $text .= $sl.$sl.$sl.$tab."static function get_strippeds (\$stripped, \$relation_id = ''){".$sl;
      
      $text .= $sl.$tab.$tab."\$con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER ); ";
    
      $text .= $sl.$tab.$tab."\$lng = Cutils::get_actual_lng();";
      
      
      $text .= $sl.$sl.$tab.$tab."\$query = \"SELECT ";
      //Añadimos el stripped al sql 
      if ( isset( $arrayjson['stripped'] ) ) {
        
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
            
            foreach ($array_languages as $item ) {
            	
              $text .= "stripped_".$item.", ";
              
            }
            
            }else{
              
              $text .= "stripped, ";
            
          } 
          
          $text = substr( $text, 0, -2 );  
        
      }
      
      
      $text .= " FROM ".$arrayjson['name']." WHERE stripped_\$lng = '\$stripped'  ";
      
      if ( $arrayjson['type'] == 'webform_relational')  {
        $text .= " and ".$name_of_relation."_id = '\$relation_id' \";";
      }else if ( $arrayjson['type'] == 'webform')  {
        $text .= "\";";
      }
      
      
      $text .= $sl.$sl.$tab.$tab."\$item = \$con->fetch_one_result(\$query);";
      
      $text .= $sl.$sl.$tab.$tab."if (\$item)";
      $text .= $sl.$tab.$tab.$tab."return \$item; ";
      $text .= $sl.$tab.$tab."else";
      $text .= $sl.$tab.$tab.$tab."return false; ";
    
    $text .= $sl.$tab."}".$sl;
    
    
    
     //Get type
    $text .= $sl.$sl.$sl.$tab."static function get_type (){".$sl;
    
      if ( $arrayjson['type'] == 'webform_relational')  {
        $text .= $sl.$tab.$tab."return 'webform_relational'; ".$sl;
      } else if ( $arrayjson['type'] == 'webform'){
        $text .= $sl.$tab.$tab."return 'webform'; ".$sl;
    }
    
    $text .= $sl.$tab."}".$sl;
   
    //fi Get type
    
    
    
    //Get name_stripped
    $text .= $sl.$sl.$tab."static function get_name_stripped (){".$sl;
    
      if ( isset($arrayjson['stripped'] ) ) {
        $text .= $sl.$tab.$tab."return '".$arrayjson['stripped']."'; ".$sl;
      }else{
        $text .= $sl.$tab.$tab."return ''; ".$sl;
      }
    
    $text .= $sl.$tab."}".$sl;
   
    //fi Get name_stripped
    
     
    //Get name_stripped
    $text .= $sl.$sl.$tab."static function is_multilanguage (){".$sl;
    
      if ($is_multilanguage ) {
        $text .= $sl.$tab.$tab."return true; ".$sl;
      }else{
        $text .= $sl.$tab.$tab."return false; ".$sl;
      }
    
    
    $text .= $sl.$tab."}".$sl;
   
    //fi Get name_stripped  
        
    

//fin de clase
$text .= $sl."}".$sl; 

$text .= "?>".$sl;
  

$archivo=fopen("../clases/c".$arrayjson['name'].".php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Modelo creado con &eacute;xito (/clases/c".$arrayjson['name'].".php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el modelo <br />";
}
  
$text = '';


//***********************************/
//** * FIN CREACION DEL MODELO * ****/
//***********************************/





//***********************************/
//** * CFORMCONSTURCT * *************/
//***********************************/

echo "<br/><b>Constructor de formularios</b> </br>";

$text = "<?php ". $sl;

//$text .= "require_once('config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cdatabase.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpaginado.php'); $sl $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cform_construct.php'); $sl $sl";

$text .= "class Cform_construct_".$arrayjson['name']." extends  Cform_construct {";


   if ( $arrayjson['type'] == 'webform_relational')  {
    
    $text .= $sl.$sl.$tab."var \$m_item_id;";   
    $text .= $sl.$tab."var \$m_relation_id;";  
    $text .= $sl.$tab."var \$m_return;";  
     
    $text .= $sl.$sl.$tab."function Cform_construct_".$arrayjson['name']."(\$form_name = '', \$lng = 'es', \$type = 'new', \$item_id = '', \$relation_id = '', \$return = '' ){";
    
    $text .= $sl.$sl.$tab.$tab."\$this->m_relation_id = \$relation_id;";
    $text .= $sl.$tab.$tab."\$this->m_return = \$return;";
    $text .= $sl.$tab.$tab."\$this->m_item_id = \$item_id;";
 
   }else if ( $arrayjson['type'] == 'webform'){
     
     $text .= $sl.$sl.$tab."var \$m_item_id;"; 
     
     $text .= $sl.$sl.$tab."function Cform_construct_".$arrayjson['name']."(\$form_name = '', \$lng = 'es', \$type = 'new', \$item_id = ''){";
     
     $text .= $sl.$sl.$tab.$tab."\$this->m_item_id = \$item_id;";
     
   }

    $text .= $sl.$sl.$tab.$tab."Cform_construct_".$arrayjson['name']."::Cform_construct(\$form_name, \$lng, \$type); ";
	
  $text .= $sl.$tab."}".$sl; //fi constructor
	
	
  $text .= $sl.$sl.$tab."function get_item_id(){";
	  $text .= $sl.$tab.$tab."return \$this->m_item_id; ";
	$text .= $sl.$tab."} ";
	
	//función populate
	$text .= $sl.$sl.$sl.$tab."function populate(\$fillbd = true){";
	  $text .= $sl.$tab.$tab."\$this->m_form_object = new Cform(\$this->get_form_name(), \$this->get_form_name(), htmlentities(\$_SERVER['PHP_SELF'], ENT_QUOTES), 'post'); ";
	  
	  foreach ($arrayjson['campos'] as $index => $value ){
	    
	    switch ($value['type']){
	      
	      case 'text':
	        
            if ( $value['multilanguage']){
          
            $text_aux = '';
          
            foreach ($array_languages as $item ) {
    	        
              $text_aux .= $sl.$sl.$tab.$tab. "\$obj = new Cform_text('".$index."_".$item."',\$this->get_form_name().'_".$index."_".$item."', '".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", 'text', ".$value['minlength'].", ".$value['maxlength'].", ".$value['size'].");";
    	        $text_aux .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";   
    	        
            }
            
            $text .= $text_aux;
            
          } else {
          
  	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_text('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", 'text', ".$value['minlength'].", ".$value['maxlength'].", ".$value['size'].");";
  	        $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        
          }
          
	        break;
	        
	      case 'textarea':
	        
	         if ( $value['multilanguage']){
          
            $text_aux = '';
          
            foreach ($array_languages as $item ) {
                
              $text_aux .= $sl.$sl.$tab.$tab. "\$obj = new Cform_textarea('".$index."_".$item."',\$this->get_form_name().'_".$index."_".$item."', '".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", ".$value['cols'].", ".$value['minlength'].", ".$value['maxlength'].", ".$value['rows'].");";
    	      	$text_aux .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
              
            }
            
            $text .= $text_aux;
            
	         } else {
	        
  	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_textarea('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", ".$value['cols'].", ".$value['minlength'].", ".$value['maxlength'].", ".$value['rows'].");";
  	      	$text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
  	      	
	         }
	         
	        break;
	        	        
	      case 'datepicker':
	        
  	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_datepicker('".$index."',\$this->get_form_name().'_".$index."', 'datepicker ".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", 'text', 10, 10, 10);";
  	        $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
  	        
	        break;

	        
	       case 'numeric':
	        
	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_numeric('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['value']."', ".$value['mandatory'].", 'text', ".$value['minlength'].", ".$value['maxlength'].", ".$value['size'].");";
	      	$text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        break;
	        
	      case 'radio':
	        
	        foreach ($value['options'] as $index2 => $value2){
	           $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_radio('".$index2."', \$this->get_form_name().'_".$index."', '".$value2['class']."', '', '".$value2['value']."', '".$value['mandatory']."', ".$value2['checked']."); ";
	           $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        }
	        
	        break;
	        	        
	      case 'select':
	        
	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_select('".$index."', \$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['mandatory']."', '".$value['with_language']."', ".$value['with_default_value'].", ".$value['lng'].", ".$value['size'].", ".$value['multiple']."); ";
  	        foreach ($value['options'] as $index2 => $value2){ 
  	         $text .= $sl.$tab.$tab.$tab."\$obj->add_option_without_languages('".$value2['value']."', '".$value2['text']."' , ".$value2['selected']."); ";
  	        }
	        $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        
	        break;

	        
	       case 'selectbd':
	        
	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_select('".$index."', \$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['mandatory']."', '".$value['with_language']."', ".$value['with_default_value'].", ".$value['lng'].", ".$value['size'].", ".$value['multiple']."); ";
  	     
  	         $text .= $sl.$tab.$tab.$tab."\$obj->add_option_from_bd('".$value['options']['table']."', '".$value['options']['idshow']."', '".$value['options']['nameshow']."', '".$value['options']['queryoptions']."', '".$value['options']['default']."' )  ; ";
  	        
	        $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        
	        break;   
	        
	        
	      case 'checkbox':
          
	        $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_checkbox('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', ".$value['value'].", ".$value['checked'].",  ".$value['mandatory'].", ".$value['disabled'].", ".$value['readonly'].", ".$value['tabindex'].");";
	        $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        break;
	        
	      
	      case 'image':
          
	        $text .= $sl.$sl.$tab.$tab."if (\$this->m_type == 'new'){";
	         $text .= $sl.$sl.$tab.$tab.$tab. "\$obj = new Cform_image('".$index."',\$this->get_form_name().'_".$index."', '', '', '', '".$value['mandatory']."');";
	         $text .= $sl.$tab.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        $text .= $sl.$sl.$tab.$tab."}else{";
	         $text .= $sl.$sl.$tab.$tab.$tab. "\$obj = new Cform_image('".$index."',\$this->get_form_name().'_".$index."', '', '', '', '0');";
	         $text .= $sl.$tab.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        $text .= $sl.$sl.$tab.$tab."}";
	        break;
	        
	       
	      case 'file':
          
	        $text .= $sl.$sl.$tab.$tab."if (\$this->m_type == 'new'){";
	         $text .= $sl.$sl.$tab.$tab.$tab. "\$obj = new Cform_doc('".$index."',\$this->get_form_name().'_".$index."', '', '', '', '".$value['mandatory']."', '".$value['extensions']."');";
	         $text .= $sl.$tab.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        $text .= $sl.$sl.$tab.$tab."}else{";
	         $text .= $sl.$sl.$tab.$tab.$tab. "\$obj = new Cform_doc('".$index."',\$this->get_form_name().'_".$index."', '', '', '', '0', '".$value['extensions']."');";
	         $text .= $sl.$tab.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        $text .= $sl.$sl.$tab.$tab."}";
	        break;
	        
	       
	      case 'hidden':
	        
	        if ($value['value'] == 'relation_id'){
	         $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_hidden('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', \$this->m_relation_id, ".$value['maxlength'].", 'text', ".$value['mandatory']." );";  
	        }else{
	          $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_hidden('".$index."',\$this->get_form_name().'_".$index."', '".$value['class']."', '', '".$value['value']."', ".$value['maxlength'].", 'text', ".$value['mandatory']." );";
	        }
	        
	      	$text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";
	        break;
	        	        
	    }
	  } //fin foreach
	  
	  //hidden item para el edit
		$text .= $sl.$sl.$tab.$tab."if (\$this->m_type == 'edit'){";
		  $text .= $sl.$tab.$tab.$tab. "\$obj = new Cform_hidden('item_id', \$this->get_form_name().'_item_id', '', '', \$this->m_item_id); ";
		  $text .= $sl.$tab.$tab.$tab. "\$this->m_form_object->add_inputs(\$obj,\$obj->get_id()); ";
		$text .= $sl.$tab.$tab."}";
		
	  //hidden para el valor de retorno despues de accion
	  if ( $arrayjson['type'] == 'webform_relational')  {
	   $text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_hidden('return',\$this->get_form_name().'_return', '', '', \$this->m_return, 200, 'text', 1);";  
	   $text .= $sl.$tab.$tab."\$this->m_form_object->add_inputs(\$obj,\$obj->get_id());";  
	  }
	  
	  
        	$text .= $sl.$sl.$tab.$tab. " //creacion token seguretat (anti csrf) ";
        	$text .= $sl.$tab.$tab. "\$this->create_token();";
	  
	  
	  // Boton de envio
		$text .= $sl.$sl.$tab.$tab. "\$obj = new Cform_button_submit('submit',\$this->get_form_name().'_submit','Enviar'); ";
		$text .= $sl.$tab.$tab. "\$this->m_form_object->add_inputs(\$obj,\$obj->get_id()); ";
		
		$text .= $sl.$sl.$tab.$tab. "\$this->m_form_object->close_form(); ";
		
		$text .= $sl.$sl.$tab.$tab. "// si es un edit llenamos los objetos con los campos de la base de datos";
		$text .= $sl.$tab.$tab."if (\$this->get_type() == 'edit' and \$fillbd){";
			$text .= $sl.$tab.$tab.$tab."\$this->search_and_fill_object_from_bd();";
		$text .= $sl.$tab.$tab."}";
	  
	$text .= $sl.$tab."} "; //fin populate
	  
	
	//función process
	$text .= $sl.$sl.$sl.$tab."function process(){";

    $text .= $sl.$tab.$tab."if (!isset(\$_POST[\$this->m_form_name.'_submit'])){";
    
      $text .= $sl.$sl.$tab.$tab.$tab."\$this->populate();";
      
    $text .= $sl.$sl.$tab.$tab."}else{";
    
    	     $text .= $sl.$sl.$tab.$tab.$tab."//valida token antiCSRF";
		$text .= $sl.$tab.$tab.$tab."\$this->validate_token();";
    
          $text .= $sl.$sl.$tab.$tab.$tab."//Creamos el formulario y le asignamos los valores";
		$text .= $sl.$tab.$tab.$tab."\$this->get_and_fill_submited_params();";
		
		$text .= $sl.$sl.$tab.$tab.$tab."//validamos el formulario";
		$text .= $sl.$tab.$tab.$tab."if (\$this->validate()){";
		
	 	$text .= $sl.$sl.$tab.$tab.$tab.$tab."//obtenemos los valores del formulario para hacer el save";
		$text .= $sl.$tab.$tab.$tab.$tab."\$item = \$this->fill_array_to_save();";
				
				
	     foreach ($arrayjson['campos'] as $index => $value ){
	    
	       switch ($value['type']){
	         
	         case 'checkbox':
	           $text .= $sl.$sl.$tab.$tab.$tab.$tab."//Obtenemos el valor del checkbox";
	           $text .= $sl.$tab.$tab.$tab.$tab."\$item['$index'] = (\$item['$index'] != '') ?  \$item['$index'] = 1 : \$item['$index'] = 0; ";
	           break;
	           
	         case 'image':
	           $text .= $sl.$sl.$tab.$tab.$tab.$tab."//Creamos el objeto imagen";
	           $text .= $sl.$tab.$tab.$tab.$tab."\$image = new Cimagen(\$this->get_form_name(), 'image', '', '".$arrayjson['name']."');";
	           $text .= $sl.$tab.$tab.$tab.$tab."\$ruta_img = \$image->get_url_photo_to_save();";
	           break;

	         case 'file':
	           $text .= $sl.$sl.$tab.$tab.$tab.$tab."//Creamos el objeto file";
	           $text .= $sl.$tab.$tab.$tab.$tab."\$archivo = new Carchivo(\$this->get_form_name(), 'file', '', '".$arrayjson['name']."');";
	           $text .= $sl.$tab.$tab.$tab.$tab."\$ruta_archivo = \$archivo->get_url_photo_to_save();";
	           break;
	           
	         
	       }
	       
			  }
				
				$text .= $sl.$sl.$tab.$tab.$tab.$tab."if (\$this->m_type == 'new'){";
				  
  				$text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."//creamos el objeto cusers";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."\$newitem = new C".$arrayjson['name']."('', ";
  				
  				foreach ($arrayjson['campos'] as $index => $value ){
          
  				  switch ($value['type']){
  				    
    				  case 'text':
              case 'textarea':
              
                $aux = '';
              
                if ( $value['multilanguage']){
      				    
                  foreach ($array_languages as $item ) {
                    $text .= "\$item['".$index."_".$item."'], ";
                  }
                  
      				  } else {
      				    $text .= "\$item['$index'], ";
      				  }
      				  
      				  break;
      				  
              case 'image':
                $text .= "\$ruta_img, ";
                break;

                
              case 'file':
                $text .= "\$ruta_archivo, ";
                break;
                
              
              case 'datepicker':
                  $text .= "Cutils::to_english_dates(\$item['$index']), ";
                break;
                
                
              default:
                
                $text .= "\$item['$index'], ";
                break;
    				  
  				    }
          }
          
          $text = substr( $text, 0, -2 ) .");";
          
          
          
          
          //Si es un stripped hemos de mirar ke no ete creado ya en la BD
          if ( isset($arrayjson['stripped'] ) ) {
  
            $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."//Si es un stripped hemos de mirar ke no ete creado ya en la BD";
            
            if ($is_multilanguage ) {
              
              if ( $arrayjson['type'] == 'webform')  {
                
                $text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (! \$newitem->is_unique(";
                
                foreach ($array_languages as $item ) {
                  $text .= "\$item['".$arrayjson['stripped']."_".$item."'], ";
                }
          
                $text = substr( $text, 0, -2 ) ;  
                $text .=") ){";
                
              } else if ( $arrayjson['type'] == 'webform_relational')  {
               
                  $text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (! \$newitem->is_unique(";
                
                foreach ($array_languages as $item ) {
                  $text .= "\$item['".$arrayjson['stripped']."_".$item."'], ";
                }
          
                $text .="\$item['".$name_of_relation."_id']) ){";  
                
              }
              
            }else{
              
              if ( $arrayjson['type'] == 'webform')  {
                
                $text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (! \$newitem->is_unique(\$item['".$arrayjson['stripped']."'])){";
                
              } else if ( $arrayjson['type'] == 'webform_relational')  {
                
                $text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (! \$newitem->is_unique(\$item['".$arrayjson['stripped']."'], \$item['".$name_of_relation."_id'] )){";
                
              }
              
            }
            
            $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$this->set_info_action_form_failed('Ya hay un item creado con estos datos', 0); ";
            if ( $arrayjson['type'] == 'webform_relational')  {
    				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/'.\$item['return'].'/');";
    				}else if ( $arrayjson['type'] == 'webform')  {
    				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/');";
    				}  
  				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."exit(); ";
  				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."}";
                
          }
          
          
          
          
          //Guardamos el objeto
          $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."// guardamos el objeto";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (\$newitem->save()){";
  				
  				
  				foreach ($arrayjson['campos'] as $index => $value ){
	    
  	       switch ($value['type']){
  	         
  	         case 'image':
  	           
  	           $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."//Subimos la imagen y creamos el thumb";
  	           $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$result = \$image->move();";
  	           $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."if (\$result['correct'])";
  	           $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab.$tab."\$image->do_thumbnail();";
  	           break;

  	         case 'file':
  	           
  	           $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."//Subimos el archivo";
  	           $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$result = \$archivo->move();";
  	           break;
  	           
  	       }
  				}
  				
  			   $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$this->set_info_action_form_success('Item guardado correctamente', 0); ";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."}else {";
  				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$this->set_info_action_form_failed('Error creando el item', 0); ";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."}";
  				
  				if ( $arrayjson['type'] == 'webform_relational')  {
  				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/'.\$item['return'].'/');";
  				}else if ( $arrayjson['type'] == 'webform')  {
  				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/');";
  				}  
				  $text .= $sl.$tab.$tab.$tab.$tab.$tab ."exit(); ";
          
				
				$text .= $sl.$sl.$tab.$tab.$tab.$tab."}else if (\$this->m_type == 'edit'){//fi type==new";
			
				//Borramos una imagen anterior si existe un campo image
			  foreach ($arrayjson['campos'] as $index => $value ){

			    switch ($value['type']){
			      
              case 'image':
                $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab."//Si hay una imagen nueva borramos la anterior";
    				    $text .= $sl.$tab.$tab.$tab.$tab.$tab."if (\$ruta_img){";
    				    $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab."Cimagen::delete(Cimagen::get_ruta_from_id('".$arrayjson['name']."', \$item['item_id']));";
    				    $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab."}";
    				    break;

    				  case 'file':
                $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab."//Si hay un archivo borramos el anterior";
    				    $text .= $sl.$tab.$tab.$tab.$tab.$tab."if (\$ruta_archivo){";
    				    $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab."Carchivo::delete(Carchivo::get_ruta_from_id('".$arrayjson['name']."', \$item['item_id']));";
    				    $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab."}";
    				    break;
                
            }

				  
        }
				
				
				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."//Obtenemos el objeto";
				  $text .= $sl.$tab.$tab.$tab.$tab.$tab ."\$edititem = new C".$arrayjson['name']."(\$item['item_id']);";
				  $text .= $sl.$tab.$tab.$tab.$tab.$tab ."\$edititem->edit( ";
				  
				  foreach ($arrayjson['campos'] as $index => $value ){
  				  
				    switch ($value['type']){
  				    
    				  case 'text':
              case 'textarea':
              
                $aux = '';
              
                if ( $value['multilanguage']){
      				    
                  foreach ($array_languages as $item ) {
                    $text .= "\$item['".$index."_".$item."'], ";
                  }
                  
                } else {
                  $text .= "\$item['$index'], ";  
                }
                
                break;
                
              case 'image':
                
                $text .= "\$ruta_img, ";
                break;

              case 'file':
                
                $text .= "\$ruta_archivo, ";
                break;
                
                
              case 'datepicker':
                  $text .= "Cutils::to_english_dates(\$item['$index']), ";
                break;
                
              
              default:
                
                $text .= "\$item['$index'], ";
                break;
                
				    }
				 
          }
          
          $text = substr( $text, 0, -2 ) .");";
				  
				  
				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."// editamos el objeto";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."if (\$edititem){";
  				
  				foreach ($arrayjson['campos'] as $index => $value ){
            
  				  switch ($value['type']){
              
  				    case 'image':
  				      
      				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab."//Subimos la imagen y creamos el thumb";
      				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab."\$result = \$image->move();";
      				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab."if (\$result['correct'])";
      				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab.$tab."\$image->do_thumbnail();";  				      
  				      break;
  				      
  				    
  				    case 'file':
  				      
                $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab."//Subimos el archivo";
      				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab."\$result = \$archivo->move();";
  				      break;
  				    
            }

				    
  				}
  			
  			   $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$this->set_info_action_form_success('Item editado correctamente', 0); ";
  				$text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."}else {";
  				  $text .= $sl.$tab.$tab.$tab.$tab.$tab.$tab ."\$this->set_info_action_form_failed('Error editando el item', 0); ";
  				$text .= $sl.$tab.$tab.$tab.$tab.$tab ."}";
  				
  				if ( $arrayjson['type'] == 'webform_relational')  {
  				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/'.\$item['return'].'/');";
  				}else if ( $arrayjson['type'] == 'webform')  {
  				  $text .= $sl.$sl.$tab.$tab.$tab.$tab.$tab ."Clocation::header_location('/admin/".$arrayjson['name']."/list/');";
  				}  
  				
				  $text .= $sl.$tab.$tab.$tab.$tab.$tab ."exit(); ";
				
				$text .= $sl.$sl.$tab.$tab.$tab.$tab."}//fi else type='edit'";
			
			$text .= $sl.$tab.$tab.$tab."}//fi validate";
    
    $text .= $sl.$sl.$tab.$tab."}//fi else _post";

  $text .= $sl.$tab."}//fin process"; 
  
  
  $text .= $sl.$sl.$tab."function search_and_fill_object_from_bd(){";
  
  	$text .= $sl.$tab.$tab."// Buscamos en la base de datos los usuarios";
		$text .= $sl.$tab.$tab."\$item = new C".$arrayjson['name']."(\$this->get_item_id()); ";
		$text .= $sl.$tab.$tab."\$resultat = \$item->load_item_to_array(); ";
		
		$text .= $sl.$sl.$tab.$tab."// Llenamos el objeto formulario con los valores de la bd";
		$text .= $sl.$tab.$tab."\$this->fill_object_from_bd(\$resultat);";
		
  $text .= $sl.$sl.$tab."}//fin search_and_fill"; 
  

//fin de clase
$text .= $sl.$sl."}".$sl; 


$text .= "?>".$sl;

$archivo=fopen("../clases/cform_construct_".$arrayjson['name'].".php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Constructor de formularios creado con &eacute;xito (/clases/cform_construct_".$arrayjson['name'].".php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el constructor de formularios <br />";
}


//***********************************/
//** * FIN CFORMCONSTURCT * *********/
//***********************************/



echo "<br/><b>Constroladores</b> </br>";


//***********************************/
//** * CONTROLADOR CREATE * *********/
//***********************************/

$text = "<?php ". $sl;

//Adjuntamos archivos
$text .= "require_once('../config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cform_construct_".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpagelayout_backend.php'); $sl";

if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= "require_once(PATH_ROOT_CLASES . 'c".$name_of_relation.".php'); $sl";
}

$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl $sl";


$text .="// Definimos las seccins del layout $sl";
$text .="\$names_section = array( $sl";
  $text .= $tab."'top' 			=> 	'vtop', ";
  $text .= $sl.$tab."'menu' 			=> 	'vmenu',  ";
  $text .= $sl.$tab."'main' 			=> 	'v".$arrayjson['name']."_create', ";
  $text .= $sl.$tab."'footer'		=>	'vfooter' ";
$text .= $sl.");";



//si es una webform_relational añadimos el valor del hidden al constructor (relacion con la tabla)
$relation_id = '';

if ( $arrayjson['type'] == 'webform_relational')  {
       
  //recogemos la relacion que puede ser un stripped o un id //afegir ";
  $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
  	$text .=$sl.$tab."\$id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$return  =  \$id;";
  $text .=$sl."}else if ( isset( \$_REQUEST['stripped']) ){ ";
  	$text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$id = C".$name_of_relation."::get_id_from_stripped(\$stripped); ";
  	$text .=$sl.$tab."\$return = \$stripped; ";
  $text .=$sl."} ";
  
  $text .=$sl.$sl."//incluimos el formulario de usuarios y lo añadimos al array de formularios";
  $text .=$sl."\$newform = new Cform_construct_".$arrayjson['name']."('cform".$arrayjson['name']."','es','new','', \$id, \$return);";
  $text .=$sl."\$array_forms['cform".$arrayjson['name']."'] = \$newform; ";
  
}else if ( $arrayjson['type'] == 'webform'){
 
  $text .=$sl.$sl."//incluimos el formulario de usuarios y lo añadimos al array de formularios";
  $text .=$sl."\$newform = new Cform_construct_".$arrayjson['name']."('cform".$arrayjson['name']."','es','new');";
  $text .=$sl."\$array_forms['cform".$arrayjson['name']."'] = \$newform; ";
  
}

$write_validation         = true;
$only1datapicker          = true;
$writeinfodatapicker    = false;
$writeckeditor             = false;

//Miramos si hay una imagen para pasarle al validador la special class
foreach ($arrayjson['campos'] as $index => $value ){
  
  switch ($value['type']){
    
    case 'image':
      
      if ( $value['mandatory'])
        $special_class = ', \'requiredimage\' ';
      else 
        $special_class = ', \'image\' '; 
        
      $text .=$sl.$sl."//incluimos la validacion por javascript";
      $text .=$sl."\$heredoc = Cutils::get_scripts_heredoc_form_validation(\$array_forms $special_class);";
      
      $write_validation = false;
      
      break;
      
      
    case 'file':
      
      if ( $value['mandatory'])
        $special_class = ', \'requireddoc\' ';
      else 
        $special_class = ', \'doc\' '; 
        
      $text .=$sl.$sl."//incluimos la validacion por javascript";
      $text .=$sl."\$heredoc = Cutils::get_scripts_heredoc_form_validation(\$array_forms $special_class);";
      
      $write_validation = false;
      
      break;
      
    case 'datepicker':
      
      if ($only1datapicker){
        
        
        $textdatapicker =$sl.$sl."//Añadimos las llamadas javascript para mostrar el datapicker";
        $textdatapicker .=$sl."\$lng = Cutils::get_actual_lng();";
        
        $textdatapicker .=$sl."\$heredocaux  =<<< html";
          $textdatapicker .=$sl."<script>";
          	$textdatapicker .=$sl.$tab."$(function() {";
          	     $textdatapicker .=$sl.$tab.$tab."$.datepicker.setDefaults($.datepicker.regional['\$lng']); ";
        		$textdatapicker .=$sl.$tab.$tab."$( \".datepicker\" ).datepicker( {dateFormat: 'dd-mm-yy'} ); ";
        	$textdatapicker .=$sl.$tab."});";
          $textdatapicker .=$sl."</script>";
        $textdatapicker .=$sl."html;";
        
        $textdatapicker .=$sl.$sl."\$heredoc .= \$heredocaux;";
        
        $only1datapicker = false;
        $writeinfodatapicker = true;
      }
      
      break;
      
      
    case 'textarea':
      
      if ( $value['ckeditor']){
      
        $writeckeditor  = true;
        
        if ( $value['multilanguage']){
         
          $ckeditor = $sl.$sl."\$path = PATH_ROOT_INCLUDES;";
          $ckeditor .= $sl."\$heredoc .=<<< html";
              $ckeditor .= $sl.$sl.$tab."<script type=\"text/javascript\">";
              
                $ckeditor .= $sl.$sl.$tab.$tab."//<![CDATA[";
                $ckeditor .= $sl.$tab.$tab."window.onload = function(){";
          
                  foreach ($array_languages as $item ) {
                  
                    $ckeditor .= $sl.$tab.$tab.$tab."CKEDITOR.replace( '".$index."_".$item."', {filebrowserUploadUrl : \"{\$path}ckupload.php\"});";
                    
                  }    
          
            	 $ckeditor .= $sl.$tab.$tab."} ";  
                 $ckeditor .= $sl.$tab.$tab." //]]>";
                
                $ckeditor .= $sl.$sl.$tab."</script>";
            
           $ckeditor .= $sl.$sl."html;";             
          
        } else {

          $ckeditor = $sl.$sl."\$path = PATH_ROOT_INCLUDES;";
          $ckeditor .= $sl.$sl."\$heredoc .=<<< html";
              $ckeditor .= $sl.$sl.$tab."<script type=\"text/javascript\">";
              
                $ckeditor .= $sl.$sl.$tab.$tab."//<![CDATA[";
                $ckeditor .= $sl.$tab.$tab."window.onload = function(){";
          
                  $ckeditor .= $sl.$tab.$tab.$tab."CKEDITOR.replace( '$index', {filebrowserUploadUrl : \"{\$path}ckupload.php\"});";

          	 $ckeditor .= $sl.$tab.$tab."} ";  
               $ckeditor .= $sl.$tab.$tab." //]]>";
              
              $ckeditor .= $sl.$sl.$tab."</script>";
          
         $ckeditor .= $sl.$sl."html;";
             
        }
    }
    break; 
  }
}



if ($write_validation){
  $text .=$sl.$sl."//incluimos la validacion por javascript";
  $text .=$sl."\$heredoc = Cutils::get_scripts_heredoc_form_validation(\$array_forms);";
}

//si existe un datepicker lo ponemos despues de la llamada a heredoc
if ($writeinfodatapicker){
  $text .= $textdatapicker;
}

//Si existe un textarea con ckeditor insertamos el javascript
if ($writeckeditor){
   $text .= $ckeditor;
}

$text .=$sl.$sl."\$layout	= new Cpagelayout_backend( \$names_section ); ";

  $text .=$sl.$tab."\$layout->set_page_link_blocker(true);";
  $text .=$sl.$tab."\$layout->set_page_forms(\$array_forms);";
  
  if ($writeinfodatapicker){
    	$text .=$sl.$tab."\$layout->set_page_styles(array(PATH_ROOT_CSS.'cupertino/jquery-ui-1.8.9.custom.css'));";
	$text .=$sl.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'jquery-ui-1.8.9.custom.min.js'));";
	$text .=$sl.$tab."if (\$lng != 'en'){";
	 $text .=$sl.$tab.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'ui/jquery.ui.datepicker-'.\$lng.'.js'));";
	$text .=$sl.$tab."}";
  }
  
  if ($writeckeditor){
    $text .=$sl.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'ckeditor/ckeditor.js'));";
  }
  
  $text .=$sl.$tab."\$layout->set_page_heredoc(\$heredoc);";

  $text .=$sl.$tab."\$layout->set_var('form_type', 'new');";
  
  if ( $arrayjson['type'] == 'webform_relational')  {
    $text .=$sl.$tab."\$layout->set_var('return', \$return);";
    $text .=$sl.$tab."\$layout->set_var('rid', \$id);";
  }

$text .=$sl."\$layout->Display();";


$text .= $sl."?>".$sl;

$archivo=fopen("../admin/".$arrayjson['name']."_create.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Controlador create creado con &eacute;xito (/".$arrayjson['name']."_create.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el controlador create <br />";
}
//***********************************/
//** *END CONTROLADOR CREATE ********/
//***********************************/



//***********************************/
//** * CONTROLADOR EDIT * ***********/
//***********************************/

$text = "<?php ". $sl;

//Adjuntamos archivos
$text .= "require_once('../config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cform_construct_".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpagelayout_backend.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cimagen.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl $sl";

if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= "require_once(PATH_ROOT_CLASES . 'c".$name_of_relation.".php'); $sl";
}



$text .="// Definimos las seccins del layout $sl";
$text .="\$names_section = array( $sl";
  $text .= $tab."'top' 			=> 	'vtop', ";
  $text .= $sl.$tab."'menu' 			=> 	'vmenu',  ";
  $text .= $sl.$tab."'main' 			=> 	'v".$arrayjson['name']."_create', ";
  $text .= $sl.$tab."'footer'		=>	'vfooter' ";
$text .= $sl.");".$sl;


if ( isset( $arrayjson['stripped'] ) ) {
  $text .=$sl."//Recojemos el id del usuario a ver";
  $text .=$sl."if ( isset( \$_REQUEST['id']) )";
  $text .=$sl.$tab."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
  $text .=$sl."else{";
  $text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0);";
  $text .=$sl.$tab."\$id = C".$arrayjson['name']."::get_id_from_stripped(\$stripped);";
  $text .=$sl."}";
}else{
  $text .=$sl."//Recojemos el id del usuario a ver";  
  $text .=$sl."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
}




$text .=$sl.$sl."//Miramos si existe. Si no existe enviamos a list";
$text .=$sl."\$".$arrayjson['name']." = new C".$arrayjson['name']."(\$id);";
$text .=$sl."if (!\$".$arrayjson['name']."->exists() and !isset(\$_REQUEST['cform".$arrayjson['name']."_item_id'])){";
$text .=$sl.$tab."Cutils::set_web_information(0, 'El item no existe o ha sido eliminado de la base de datos');";
$text .=$sl.$tab."Clocation::header_location('/".$arrayjson['name']."/list/');";
$text .=$sl."}";


if ( $arrayjson['type'] == 'webform_relational')  {
  
  if ( isset( $arrayjson['relation_stripped'] ) ) {
    
  $text .=$sl.$sl."//recogemos la relacion que puede ser un stripped o un id "; 
  $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset(\$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
  $text .=$sl."}else if ( isset( \$_REQUEST['stripped_id']) ){ ";
  	$text .=$sl.$tab."\$stripped_id = Cutils::get_filtered_params('stripped_id', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped_id); ";
  	$text .=$sl.$tab."\$return = \$stripped_id; ";
  $text .=$sl."} ";
  
  }else{
    
    $text .=$sl.$sl."//recogemos la relacion que puede ser un stripped o un id "; 
    $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
    $text .=$sl."}else if ( isset( \$_REQUEST['stripped']) ){ ";
    	$text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped); ";
    	$text .=$sl.$tab."\$return = \$stripped; ";
    $text .=$sl."} ";    
    
  }
  
  $text .=$sl.$sl."//incluimos el formulario de usuarios y lo añadimos al array de formularios";
  $text .=$sl."\$newform = new Cform_construct_".$arrayjson['name']."('cform".$arrayjson['name']."','es','edit', \$id, \$".$name_of_relation."_id, \$return);";
  $text .=$sl."\$array_forms['cform".$arrayjson['name']."'] = \$newform; ";

}else if ( $arrayjson['type'] == 'webform'){
 
  $text .=$sl.$sl."//incluimos el formulario de usuarios y lo añadimos al array de formularios";
  $text .=$sl."\$newform = new Cform_construct_".$arrayjson['name']."('cform".$arrayjson['name']."','es','edit',\$id);";
  $text .=$sl."\$array_forms['cform".$arrayjson['name']."'] = \$newform; ";
  
}

$only1datapicker = true;
$writeinfodatapicker = false;

//Miramos si hay una imagen para pasarle al validador la special class
foreach ($arrayjson['campos'] as $index => $value ){
  
  switch ($value['type']){
    
    case 'image':
        $special_class = ', \'image\' '; 
      break;
      
    case 'datepicker':
      
      if ($only1datapicker){
        
        
        $textdatapicker =$sl.$sl."//Añadimos las llamadas javascript para mostrar el datapicker";
        $textdatapicker .=$sl."\$lng = Cutils::get_actual_lng();";
        
        $textdatapicker .=$sl."\$heredocaux  =<<< html";
          $textdatapicker .=$sl."<script>";
          	$textdatapicker .=$sl.$tab."$(function() {";
          	     $textdatapicker .=$sl.$tab.$tab."$.datepicker.setDefaults($.datepicker.regional['\$lng']); ";
        		$textdatapicker .=$sl.$tab.$tab."$( \".datepicker\" ).datepicker( {dateFormat: 'dd-mm-yy'} ); ";
        	$textdatapicker .=$sl.$tab."});";
          $textdatapicker .=$sl."</script>";
        $textdatapicker .=$sl."html;";
        
        $textdatapicker .=$sl.$sl."\$heredoc .= \$heredocaux;";
        
        $only1datapicker = false;
        $writeinfodatapicker = true;
      }
      
      break;      

    case 'textarea':
      
      if ( $value['ckeditor']){
      
        $writeckeditor  = true;
        
        if ( $value['multilanguage']){
         
          $ckeditor = $sl.$sl."\$path = PATH_ROOT_INCLUDES;";
          $ckeditor .= $sl."\$heredoc .=<<< html";
              $ckeditor .= $sl.$sl.$tab."<script type=\"text/javascript\">";
              
                $ckeditor .= $sl.$sl.$tab.$tab."//<![CDATA[";
                $ckeditor .= $sl.$tab.$tab."window.onload = function(){";
          
                  foreach ($array_languages as $item ) {
                  
                    $ckeditor .= $sl.$tab.$tab.$tab."CKEDITOR.replace( '".$index."_".$item."', {filebrowserUploadUrl : \"{\$path}ckupload.php\"});";
                    
                  }    
          
            	 $ckeditor .= $sl.$tab.$tab."} ";  
                 $ckeditor .= $sl.$tab.$tab." //]]>";
                
                $ckeditor .= $sl.$sl.$tab."</script>";
            
           $ckeditor .= $sl.$sl."html;";             
          
        } else {

          $ckeditor = $sl.$sl."\$path = PATH_ROOT_INCLUDES;";
          $ckeditor .= $sl.$sl."\$heredoc .=<<< html";
              $ckeditor .= $sl.$sl.$tab."<script type=\"text/javascript\">";
              
                $ckeditor .= $sl.$sl.$tab.$tab."//<![CDATA[";
                $ckeditor .= $sl.$tab.$tab."window.onload = function(){";
          
                  $ckeditor .= $sl.$tab.$tab.$tab."CKEDITOR.replace( '$index', {filebrowserUploadUrl : \"{\$path}ckupload.php\"});";

          	 $ckeditor .= $sl.$tab.$tab."} ";  
               $ckeditor .= $sl.$tab.$tab." //]]>";
              
              $ckeditor .= $sl.$sl.$tab."</script>";
          
         $ckeditor .= $sl.$sl."html;";
             
        }
    }
    break; 
      
    default:
      
      $special_class = '';
      break;
  }
}


$text .=$sl.$sl."//incluimos la validacion por javascript";
$text .=$sl."\$heredoc = Cutils::get_scripts_heredoc_form_validation(\$array_forms $special_class);";


if ($writeinfodatapicker){
  $text .= $textdatapicker;
}

//Si existe un textarea con ckeditor insertamos el javascript
if ($writeckeditor){
   $text .= $ckeditor;
}


$text .=$sl.$sl."\$layout	= new Cpagelayout_backend( \$names_section ); ";

  $text .=$sl.$tab."\$layout->set_page_link_blocker(true);";
  $text .=$sl.$tab."\$layout->set_page_forms(\$array_forms);";
  $text .=$sl.$tab."\$layout->set_page_heredoc(\$heredoc);";
  
  if ($writeinfodatapicker){
    $text .=$sl.$tab."\$layout->set_page_styles(array(PATH_ROOT_CSS.'cupertino/jquery-ui-1.8.9.custom.css'));";
    $text .=$sl.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'jquery-ui-1.8.9.custom.min.js'));";
    $text .=$sl.$tab."if (\$lng != 'en'){";
      $text .=$sl.$tab.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'ui/jquery.ui.datepicker-'.\$lng.'.js'));";
    $text .=$sl.$tab."}";
  }
  
  if ($writeckeditor){
    $text .=$sl.$tab."\$layout->set_page_js_scripts(array(PATH_ROOT_JS.'ckeditor/ckeditor.js'));";
  }
  
  $text .=$sl.$tab."\$layout->set_var('form_type', 'edit');";
  $text .=$sl.$tab."\$layout->set_var('id', \$id);";
  $text .=$sl.$tab."\$layout->set_var('table', '".$arrayjson['name']."');";
  
  if ( $arrayjson['type'] == 'webform_relational')  {
    $text .=$sl.$tab."\$layout->set_var('return', \$return);";
    $text .=$sl.$tab."\$layout->set_var('rid', \$".$name_of_relation."_id);";
  }

$text .=$sl."\$layout->Display();";


$text .= $sl."?>".$sl;

$archivo=fopen("../admin/".$arrayjson['name']."_edit.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Controlador edit creado con &eacute;xito (/".$arrayjson['name']."_edit.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el controlador edit <br />";
}

//***********************************/
//** *END CONTROLADOR EDIT **********/
//***********************************/




//***********************************/
//** * CONTROLADOR LIST *************/
//***********************************/
$text = "<?php ". $sl;

//Adjuntamos archivos
$text .= "require_once('config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cform_construct_".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpagelayout_frontend.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl";


if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= "require_once(PATH_ROOT_CLASES . 'c".$name_of_relation.".php'); $sl";
}

$text .= "require_once(PATH_ROOT_CLASES . 'cimagen.php'); $sl ";
$text .= "//#NO-BORRAR#//".$sl.$sl;

$text .= $sl."//Recojemos la pagina actual";
$text .= $sl."\$pag  = Cutils::get_filtered_params('pag', 0, 0, 1, 0); ";
$text .= $sl."if (\$pag == 0) \$pag = 1;";


if ( $arrayjson['type'] == 'webform_relational')  {
  
  $text .=$sl.$sl."//recogemos ".$name_of_relation." que puede ser un stripped o un id "; 
  $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
  $text .=$sl."}else if ( isset( \$_REQUEST['stripped']) ){ ";
  	$text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped); ";
  	$text .=$sl.$tab."\$return = \$stripped; ";
  $text .=$sl."} ";
  
}


$text .= $sl.$sl."//Creamos un array con los parametros que se enviaran a traves del paginado ";
$text .= $sl."\$params_get = array();";


$text .=$sl.$sl."// Definimos las seccins del layout $sl";
$text .="\$names_section = array( $sl";
  $text .= $tab."'top' 			=> 	'vtop', ";
  $text .= $sl.$tab."'menu' 			=> 	'vmenu',  ";
  $text .= $sl.$tab."'main' 			=> 	'v".$arrayjson['name']."_list', ";
  $text .= $sl.$tab."'footer'		=>	'vfooter' ";
$text .= $sl.");".$sl;


$text .= $sl."\$metas = array('nocache'=>'' );";


$text .=$sl.$sl."\$layout	= new Cpagelayout_frontend( \$names_section ); ";

  $text .=$sl.$tab."\$layout->set_page_metas(\$metas);";

  if ( $arrayjson['type'] == 'webform_relational')  {
    
    $text .=$sl.$sl.$tab."\$item_array = C".$arrayjson['name']."::item_list(\$".$name_of_relation."_id, MAX_ITEMS, \$pag);";
    
    if ( isset( $arrayjson['relation_stripped'] ) )
      $text .=$sl.$tab."\$paginate = new Cpaginado(MAX_ITEMS,\$pag,\$item_array['total'],\$params_get, 'frontend'); ";
    else 
      $text .=$sl.$tab."\$paginate = new Cpaginado(MAX_ITEMS,\$pag,\$item_array['total'],\$params_get, 'frontend', 2); ";
    
  }else  if ( $arrayjson['type'] == 'webform'){
    
    $text .=$sl.$sl.$tab."\$item_array = C".$arrayjson['name']."::item_list(MAX_ITEMS, \$pag);";
    $text .=$sl.$tab."\$paginate = new Cpaginado(MAX_ITEMS,\$pag,\$item_array['total'],\$params_get); ";
    
  }
  
	$text .=$sl.$tab."\$paginat_box = \$paginate->RetornaPaginatLlistat('',false); ";
	
  $text .=$sl.$sl.$tab."\$layout->set_var('item', \$item_array['item']);";
  
  if ( $arrayjson['type'] == 'webform_relational')  {
     $text .=$sl.$tab."\$layout->set_var('return', \$return);";
     $text .=$sl.$tab."\$layout->set_var('rid', \$".$name_of_relation."_id);";
  }
  
  $text .=$sl.$tab."\$layout->set_var('paginate', \$paginat_box);";

$text .=$sl.$sl."\$layout->Display();";


$text .= $sl."?>".$sl;

$archivo=fopen("../".$arrayjson['name']."_list.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);


if ($admin){
  
  //Cambiamos la ruta de config
  $text = str_replace("require_once('config.php')", "require_once('../config.php')", $text);
  
  //Cambiamos la ruta de la clase
  $text = str_replace("cpagelayout_frontend.php", "cpagelayout_backend.php", $text);
  
  //Cambiamos el layout
  $text = str_replace("new Cpagelayout_frontend", "new Cpagelayout_backend", $text);
  
  
  $archivo=fopen("../admin/".$arrayjson['name']."_list.php" , "w");
  
  if ($archivo) {
    $result = fputs ($archivo, $text);
  }
  fclose ($archivo);
}


if ($result){
  echo "<font color='green'> &rArr; </font> Controlador list creado con &eacute;xito (/".$arrayjson['name']."_list.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el controlador list <br />";
}

//***********************************/
//** *END CONTROLADOR LIST **********/
//***********************************/



//***********************************/
//********* VER CONTROLADOR *********/
//***********************************/
$text = "<?php ". $sl;

//Adjuntamos archivos
$text .= "require_once('config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cpagelayout_frontend.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cimagen.php'); $sl";
if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= "require_once(PATH_ROOT_CLASES . 'c".$name_of_relation.".php'); $sl";
}
$text .= "//#NO-BORRAR#//".$sl.$sl;

$text .="// Definimos las seccins del layout $sl";
$text .="\$names_section = array( $sl";
  $text .= $tab."'top' 			=> 	'vtop', ";
  $text .= $sl.$tab."'menu' 			=> 	'vmenu',  ";
  $text .= $sl.$tab."'main' 			=> 	'v".$arrayjson['name']."', ";
  $text .= $sl.$tab."'footer'		=>	'vfooter' ";
$text .= $sl.");".$sl;


if ( isset( $arrayjson['stripped'] ) ) {
  $text .=$sl."//Recojemos el id del usuario a ver";
  $text .=$sl."if ( isset( \$_REQUEST['id']) )";
  $text .=$sl.$tab."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
  $text .=$sl."else{";
  $text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0);";
  $text .=$sl.$tab."\$id = C".$arrayjson['name']."::get_id_from_stripped(\$stripped);";
  $text .=$sl."}";
}else{
  $text .=$sl."//Recojemos el id del usuario a ver";  
  $text .=$sl."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
}

if ( $arrayjson['type'] == 'webform_relational')  {
  
  if ( isset( $arrayjson['relation_stripped'] ) ) {
    
    $text .=$sl.$sl."//recogemos la relacion que puede ser un stripped o un id "; 
    $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
    $text .=$sl."}else if ( isset( \$_REQUEST['stripped_id']) ){ ";
    	$text .=$sl.$tab."\$stripped_id = Cutils::get_filtered_params('stripped_id', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped_id); ";
    	$text .=$sl.$tab."\$return = \$stripped_id; ";
    $text .=$sl."} ";
  
  }else{
    
    $text .=$sl.$sl."//recogemos la relacion que puede ser un stripped o un id "; 
    $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
    $text .=$sl."}else if ( isset( \$_REQUEST['stripped']) ){ ";
    	$text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0); ";
    	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped); ";
    	$text .=$sl.$tab."\$return = \$stripped; ";
    $text .=$sl."} ";    
    
  }
}


$text .=$sl.$sl."//Miramos si existe. Si no existe enviamos a list";
$text .=$sl."\$".$arrayjson['name']." = new C".$arrayjson['name']."(\$id);";
$text .=$sl."if (!\$".$arrayjson['name']."->exists()){";
$text .=$sl.$tab."Cutils::set_web_information(0, 'El item no existe o ha sido eliminado de la base de datos');";
$text .=$sl.$tab."Clocation::header_location('/".$arrayjson['name']."/list/');";
$text .=$sl."}";


$text .=$sl.$sl."\$layout	= new Cpagelayout_frontend( \$names_section ); ";

  $text .=$sl.$tab."\$item = new C".$arrayjson['name']."(\$id);";
  $text .=$sl.$tab."\$layout->set_var('item', \$item->load_item_to_array());";
  if ( $arrayjson['type'] == 'webform_relational')  {
   $text .=$sl.$tab."\$layout->set_var('return', \$return);";
   $text .=$sl.$tab."\$layout->set_var('rid', \$".$name_of_relation."_id);";
  }
  $text .= $sl.$tab."//#NO-BORRAR2#//";

$text .=$sl."\$layout->Display();";


$text .= $sl.$sl."?>";

$archivo=fopen("../".$arrayjson['name'].".php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($admin){
  
  //Cambiamos la ruta de config
  $text = str_replace("require_once('config.php')", "require_once('../config.php')", $text);
  
  //Cambiamos la ruta de la clase
  $text = str_replace("cpagelayout_frontend.php", "cpagelayout_backend.php", $text);
  
  //Cambiamos el layout
  $text = str_replace("new Cpagelayout_frontend", "new Cpagelayout_backend", $text);
 
  
  $archivo=fopen("../admin/".$arrayjson['name'].".php" , "w");
  
  if ($archivo) {
    $result = fputs ($archivo, $text);
  }
  fclose ($archivo);
}

if ($result){
  echo "<font color='green'> &rArr; </font> Controlador ver creado con &eacute;xito (/".$arrayjson['name'].".php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el controlador ver <br />";
}

//***********************************/
//****END VER CONTROLADOR   *********/
//***********************************/





//***********************************/
//************ ACTIONS  *************/
//***********************************/


$text = "<?php ". $sl;

//Adjuntamos archivos
$text .= "require_once('../config.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cdatabase.php'); $sl";
$text .= "require_once(PATH_ROOT_CLASES . 'cutils.php'); $sl $sl";

$text .= "\$action = Cutils::get_filtered_params('a', 1, 0, 1, 0); ";

if ( isset( $arrayjson['stripped'] ) ) {
  $text .=$sl."//Recojemos el id del usuario a ver";
  $text .=$sl."if ( isset( \$_REQUEST['id']) )";
  $text .=$sl.$tab."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
  $text .=$sl."else{";
  $text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0);";
  $text .=$sl.$tab."\$id = C".$arrayjson['name']."::get_id_from_stripped(\$stripped);";
  $text .=$sl."}";
}else{
  $text .=$sl."//Recojemos el id del usuario a ver";  
  $text .=$sl."\$id  = Cutils::get_filtered_params('id', 1, 0, 1, 0);";
}

$text .=$sl.$sl."//Miramos si existe. Si no existe enviamos a list";
$text .=$sl."\$".$arrayjson['name']." = new C".$arrayjson['name']."(\$id);";
$text .=$sl."if (!\$".$arrayjson['name']."->exists()){";
$text .=$sl.$tab."Cutils::set_web_information(0, 'El item no existe o ha sido eliminado de la base de datos');";
$text .=$sl.$tab."Clocation::header_location('/admin/".$arrayjson['name']."/list/');";
$text .=$sl."}";

if ( $arrayjson['type'] == 'webform_relational')  {
  
  $text .=$sl.$sl."//recogemos la relacion que puede ser un stripped o un id "; 
  $text .=$sl."if ( isset( \$_REQUEST['".$name_of_relation."_id']) or  isset( \$_REQUEST['cform".$name_of_relation."_".$name_of_this."_".$name_of_relation."_id'] ) ){ ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id  = Cutils::get_filtered_params('".$name_of_relation."_id', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$return  =  \$".$name_of_relation."_id;";
  $text .=$sl."}else if ( isset( \$_REQUEST['stripped']) ){ ";
  	$text .=$sl.$tab."\$stripped = Cutils::get_filtered_params('stripped', 1, 0, 1, 0); ";
  	$text .=$sl.$tab."\$".$name_of_relation."_id = C".$name_of_relation."::get_id_from_stripped(\$stripped); ";
  	$text .=$sl.$tab."\$return = \$stripped; ";
  $text .=$sl."} ";
}

$text .= $sl.$sl."if (\$action == 'delete'){";

  $text .= $sl.$sl.$tab."\$item = new C".$arrayjson['name']."(\$id);";
  
  $text .= $sl.$sl.$tab."\$result = \$item->delete();";
  
  $text .= $sl.$sl.$tab.$tab."if (\$result){";
  
    $text .= $sl.$sl.$tab.$tab.$tab."\$info_ok = 1; ";
		$text .= $sl.$sl.$tab.$tab.$tab."\$info_msg = 'Eliminado correctamente'; ";
		$text .= $sl.$sl.$tab.$tab.$tab."Cutils::set_web_information(\$info_ok, \$info_msg); ";
		 if ( $arrayjson['type'] == 'webform_relational')  {
            $text .= $sl.$sl.$tab.$tab.$tab."Clocation::header_location('/admin/".$arrayjson['name']."/list/'.\$return.'/'); ";
           }else{
		  $text .= $sl.$sl.$tab.$tab.$tab."Clocation::header_location('/admin/".$arrayjson['name']."/list/'); ";
           }
		
  $text .= $sl.$sl.$tab.$tab."}else{";
  
    $text .= $sl.$sl.$tab.$tab.$tab."\$info_ok = 0; ";
		$text .= $sl.$sl.$tab.$tab.$tab."\$info_msg = 'Error eliminando'; ";
		$text .= $sl.$sl.$tab.$tab.$tab."Cutils::set_web_information(\$info_ok, \$info_msg); ";
		 if ( $arrayjson['type'] == 'webform_relational')  {
            $text .= $sl.$sl.$tab.$tab.$tab."Clocation::header_location('/admin/".$arrayjson['name']."/list/'.\$return.'/'); ";
           }else{
		  $text .= $sl.$sl.$tab.$tab.$tab."Clocation::header_location('/admin/".$arrayjson['name']."/list/'); ";
           }
  
  $text .= $sl.$sl.$tab.$tab."}";
  
  $text .= $sl.$tab."";
  
$text .= $sl."}";



$text .= $sl.$sl."?>";


$archivo=fopen("../admin/".$arrayjson['name']."_actions.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Controlador actions creado con &eacute;xito (/".$arrayjson['name']."_actions.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando el controlador actions <br />";
}
//***********************************/
//********* END ACTIONS *************/
//***********************************/


echo "<br/><b>Vistas</b> </br>";

//***********************************/
//** VISTA CREATE/EDIT *** **********/
//***********************************/
$text = "<?php ". $sl;

if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= $sl."\$return = \$this->get_var('return'); ";
}

$text .= $sl."if (\$this->get_var('form_type') == 'new') ";
  $text .= $sl.$tab."echo \"<h1>\".\$this->translate('create_a', array('".$arrayjson['name']."')).\" </h1>\" ;";
$text .= $sl."else";
   $text .= $sl.$tab."echo \"<h1>\".\$this->translate('edit_a', array('".$arrayjson['name']."')).\" </h1>\" ;";

$text .= $sl.$sl."\$form = \$this->get_form_by_name('cform".$arrayjson['name']."'); ";
$text .= $sl."\$form->open_form_display();";
   
$text .= $sl.$sl."echo \"<table class='formtable'>\";";

 foreach ($arrayjson['campos'] as $index => $value ){
  
  switch ($value['type']){
    
    case 'text':
    case 'textarea':
      
      if ( $value['multilanguage']){
      
        foreach ($array_languages as $item ) {
          
          $text .= $sl.$sl.$tab."echo \"<tr>\";";
            $text .= $sl.$tab.$tab."echo \"<td width='130px'>".ucfirst($index)." ($item)</td>\"; ";
            $text .= $sl.$tab.$tab."echo \"<td> \". \$form->get_form_object('".$index."_".$item."')->display(true) .\" </td>\"; ";;
          $text .= $sl.$tab."echo \"</tr>\"; ";
          
        }

      
      } else {
        
        $text .= $sl.$sl.$tab."echo \"<tr>\";";
          $text .= $sl.$tab.$tab."echo \"<td width='130px'>".ucfirst($index)."</td>\"; ";
          $text .= $sl.$tab.$tab."echo \"<td> \". \$form->get_form_object('$index')->display(true) .\" </td>\"; ";;
        $text .= $sl.$tab."echo \"</tr>\"; ";
        
      }
      
      break;
    
    case 'radio':
      
      $text .= $sl.$sl.$tab."echo \"<tr>\";";
    
      $text .= $sl.$tab.$tab."echo \"<td>".ucfirst($index)."</td>\"; ";
      
      $text .= $sl.$tab.$tab."echo \"<td> ";
      
      foreach ($value['options'] as $index2 => $value2){
        $text .= " \".\$form->get_form_object('$index2')->display(true).\" ".$index2." &nbsp;&nbsp;";
      }
      
      $text .= "</td> \"; ";

      $text .= $sl.$tab."echo \"</tr>\"; ";
      
      break;
      
      
    case 'hidden':
      
      $text .= $sl.$sl.$tab."echo \"<tr>\";";
    
        $text .= $sl.$tab.$tab."echo \"<td colspan='2'> \". \$form->get_form_object('$index')->display(true) .\"</td>\"; ";
        
      $text .= $sl.$tab."echo \"</tr>\"; ";
      
      break;
 
      
    default:
      
      $text .= $sl.$sl.$tab."echo \"<tr>\";";
        $text .= $sl.$tab.$tab."echo \"<td width='130px'>".ucfirst($index)."</td>\"; ";
        $text .= $sl.$tab.$tab."echo \"<td> \". \$form->get_form_object('$index')->display(true) .\" </td>\"; ";;
      $text .= $sl.$tab."echo \"</tr>\"; ";
      
      break; 
    
  }

 }
 
 //mostramos la foto si existe un campo image 
 foreach ($arrayjson['campos'] as $index => $value ){
   if ($value['type'] == 'image'){
       
      $text .= $sl.$sl.$tab.$tab.$tab."if (\$this->get_var('form_type') == 'edit'){ ";
         $text .= $sl.$tab.$tab.$tab.$tab."echo \"<tr>\";";
         $text .= $sl.$tab.$tab.$tab.$tab.$tab."echo \"<td>\".\$this->translate('image_actual').\"</td>\";";
         $text .= $sl.$tab.$tab.$tab.$tab.$tab."echo \"<td><br /><br /><img src='\".Cimagen::get_thumbnail(PATH_ROOT_UPLOADS.Cimagen::get_ruta_from_id(\$this->get_var('table'), \$this->get_var('id'))).\"' border='0'></td>\"; ";
         $text .= $sl.$tab.$tab.$tab.$tab."echo \"</tr>\";";
       $text .= $sl.$tab.$tab.$tab."}  ";  
       
   }if ($value['type'] == 'file'){

      $text .= $sl.$sl.$tab.$tab.$tab."if (\$this->get_var('form_type') == 'edit'){ ";
         $text .= $sl.$tab.$tab.$tab.$tab."echo \"<tr>\";";
         $text .= $sl.$tab.$tab.$tab.$tab.$tab."echo \"<td>\".\$this->translate('file_actual').\"</td>\";";
         $text .= $sl.$tab.$tab.$tab.$tab.$tab."echo \"<td>\".Carchivo::show_file(Carchivo::get_ruta_from_id(\$this->get_var('table'), \$this->get_var('id'))).\"</td>\"; ";
         $text .= $sl.$tab.$tab.$tab.$tab."echo \"</tr>\";";
       $text .= $sl.$tab.$tab.$tab."}  ";       
   }
 }

 

   $text .= $sl.$sl.$sl.$tab."echo \"<tr>\"; ";
    $text .= $sl.$tab.$tab."echo \"<td>&nbsp;</td>\";";
    $text .= $sl.$tab.$tab."echo \"<td><br />\";";
    
      $text .= $sl.$tab.$tab.$tab."if (\$this->get_var('form_type') == 'edit'){ ";
        
        $text .= $sl.$tab.$tab.$tab.$tab."echo  \$form->get_form_object('item_id')->display(true); ";
        
      $text .= $sl.$tab.$tab.$tab."}  "; 
      
      if ( $arrayjson['type'] == 'webform_relational')  {
        $text .= $sl.$tab.$tab.$tab.$tab."echo  \$form->get_form_object('return')->display(true); ";
      }
      
      $text .= $sl.$tab.$tab."echo \$form->get_form_object('ts')->display(true); ";
      
      $text .= $sl.$tab.$tab."echo  \$form->get_form_object('submit')->display(true);";
      
      if ( $arrayjson['type'] == 'webform_relational')  {
        $text .= $sl.$tab.$tab."echo \"&nbsp;&nbsp; <a href='/admin/".$arrayjson['name']."/list/\$return/' class='return'>\".\$this->translate('return').\"</a>\";";
      }else if ( $arrayjson['type'] == 'webform')  {
        $text .= $sl.$tab.$tab."echo \"&nbsp;&nbsp; <a href='/admin/".$arrayjson['name']."/list/' class='return'>\".\$this->translate('return').\"</a>\";";
      }
      
    $text .= $sl.$tab.$tab."echo \"</td>\"; ";
  $text .= $sl.$tab."echo \"</tr>\";";
  
  
$text .= $sl.$sl."echo \"</table class='formtable'>\";";
$text .= $sl.$sl."\$form->close_form_display();";

$text .= $sl.$sl."?>".$sl;  
  
$archivo=fopen("../vistas/backend/main/v".$arrayjson['name']."_create.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($result){
  echo "<font color='green'> &rArr; </font> Vista create/edit creada con &eacute;xito (/vistas/frontend/main/v".$arrayjson['name']."_create.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando vista create/edit <br />";
}

//***********************************/
//** FI VISTA CREATE/EDIT *** *******/
//***********************************/




//***********************************/
//** * * * * VISTA LIST *************/
//***********************************/



$text = "<?php ". $sl;

$text .= "\$items = \$this->get_var('item'); ";
$text .= $sl."\$paginate = \$this->get_var('paginate'); ";
if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= $sl."\$return = \$this->get_var('return'); ";
}

$text .= $sl.$sl."echo \$this->get_web_information(); ";

$text .= $sl.$sl."echo \"<h1>\".\$this->translate('list_of', array('".$arrayjson['name']."')).\"</h1>\"; ";

$text .= $sl.$sl."if (\$items){";

  $text .= $sl.$sl.$tab."echo \"<table class='formattable'>\";  ";
    
    $text .= $sl.$tab.$tab."echo \"<thead>\"; ";
    
    $aux_text_img = '';
    $aux_text = '';
    
    foreach ($arrayjson['campos'] as $index => $value ){
      
      switch ($value['type']){
        
        case 'text':
        case 'textarea':
            
          /*    
          if ( $value['multilanguage']){
                
            foreach ($array_languages as $item ) {
              $aux_text .= $sl.$tab.$tab.$tab."echo \"<th>".ucfirst($index."_".$item)."</th> \"; "; 
            }
            
          } else {*/
            $aux_text .= $sl.$tab.$tab.$tab."echo \"<th>".ucfirst($index)."</th> \"; "; 
          //}
          
          break;
          
        case 'image':
          
          $aux_text_img .= $sl.$tab.$tab.$tab."echo \"<th>".ucfirst($index)."</th> \"; ";
          break;
          
        
        default:
          
           $aux_text .= $sl.$tab.$tab.$tab."echo \"<th>".ucfirst($index)."</th> \"; "; 
           break;
        
        
      }
        
    }
    
    $text .= $aux_text_img.$aux_text;
    
    $text .= $sl.$tab.$tab.$tab."echo \"<th colspan='3'>\".\$this->translate('options').\"</th>\"; ";
    
    $text .= $sl.$tab.$tab."echo \"</thead>\"; ";
    
    $text .= $sl.$tab.$tab."echo \"<tbody>\"; ";
    
    
    $text .= $sl.$tab.$tab."foreach (\$items as \$item) { ";
    
      $text .= $sl.$tab.$tab.$tab."echo \"<tr>\"; ";
      
        $aux_text_img = '';
        $aux_text = '';  
      
        foreach ($arrayjson['campos'] as $index => $value ){
          
          switch ($value['type']){
        
            case 'text':
            case 'textarea':
              
              if ( $value['multilanguage']){
                
               /* foreach ($array_languages as $item ) {*/
                  //$aux_text .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".\$item['".$index."_".$item."'].\"</td>\"; ";  
                  $aux_text .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".\$item['".$index."_'.Cutils::get_actual_lng()].\"</td>\"; ";  
                //}
                
              } else {
                $aux_text .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".\$item['$index'].\"</td>\"; ";
              }
              
              break;
              
            case 'image':
              
              $aux_text_img .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".Cimagen::show_thumbnail(\$item['$index']).\"</td>\"; ";
              break;
              
              
            case 'file':
              
              $aux_text_img .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".Carchivo::show_file(\$item['$index']).\"</td>\"; ";
              break;

            case 'datepicker':
              
              $aux_text .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".Cutils::to_spanish_dates(\$item['$index']).\"</td>\"; ";
              break;              
            
            default:
              
              $aux_text .= $sl.$tab.$tab.$tab.$tab."echo \"<td>\".\$item['$index'].\"</td>\"; ";
              break;
              
          }
          
        }
        
        
        $text .= $aux_text_img.$aux_text;
        
        if ( isset($arrayjson['stripped'] ) ) {
      
          if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
            if ( $arrayjson['type'] == 'webform_relational')  {
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\$return/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\$return/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\$return/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";
            }else if ( $arrayjson['type'] == 'webform'){
              $text .= $sl.$tab.$tab.$tab.$tab."//#NO-BORRAR#//";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";               
            }
            
          }else{
            if ( $arrayjson['type'] == 'webform_relational')  {
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\$return/\".\$item['stripped'].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\$return/\".\$item['stripped'].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\$return/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";
            }else if ( $arrayjson['type'] == 'webform'){
              $text .= $sl.$tab.$tab.$tab.$tab."//#NO-BORRAR#//";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\".\$item['stripped'].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\".\$item['stripped'].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
              $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";
            }        
          }
          
        }else{
           
          if ( $arrayjson['type'] == 'webform_relational')  {
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\$return/\".\$item['id'].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\$return/\".\$item['id'].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\$return/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";
          }else if ( $arrayjson['type'] == 'webform')  {
            $text .= $sl.$tab.$tab.$tab.$tab."//#NO-BORRAR#//";
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/\".\$item['id'].\"/'>\".\$this->translate('view').\"</a></td> \"; ";
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/edit/\".\$item['id'].\"/'>\".\$this->translate('edit').\"</a></td> \"; ";
            $text .= $sl.$tab.$tab.$tab.$tab."echo \"<td><a href='/".$arrayjson['name']."/delete/\".\$item['id'].\"/' onclick=\\\"return confirm('\".\$this->translate('confirm_delete').\"');\\\">\".\$this->translate('delete').\"</a></td> \"; ";
          }
        }
        
      
      $text .= $sl.$tab.$tab.$tab."echo \"</tr>\"; ";
    
    $text .= $sl.$tab.$tab."} ";
        
    
    $text .= $sl.$tab.$tab."echo \"</tbody>\"; ";
  
  $text .= $sl.$tab."echo \"</table>\"; ";
  
  $text .= $sl.$sl.$tab."echo \$paginate; ";
  
  $text .= $sl.$sl.$tab."echo \"<br /><br /> \"; ";

  if ( $arrayjson['type'] == 'webform_relational')  {
    $text .= $sl.$tab."echo \"<a href='/".$arrayjson['name']."/create/\$return/'>\".\$this->translate('new_item').\"</a>\"; ";
  } else if ( $arrayjson['type'] == 'webform')  {
    $text .= $sl.$tab."echo \"<a href='/".$arrayjson['name']."/create/'>\".\$this->translate('new_item').\"</a>\"; ";
  }
  
$text .= $sl.$sl."}else";
  
  if ( $arrayjson['type'] == 'webform_relational')  {
    $text .= $sl.$tab."echo \"\".\$this->translate('no_items').\" <a href='/".$arrayjson['name']."/create/\$return/'>\".\$this->translate('new_item').\"</a>\"; ";
    $text .= $sl.$sl.$tab."echo \" <br><br><a href='/".$name_of_relation."/list/'>\".\$this->translate('return_to', array('".$name_of_relation."')).\" </a>\"; ";
  } else if ( $arrayjson['type'] == 'webform')  {
    $text .= $sl.$tab."echo \"\".\$this->translate('no_items').\" <a href='/".$arrayjson['name']."/create/'>\".\$this->translate('new_item').\"</a>\"; ";
    
    $text .= $sl.$sl.$tab."echo \"<br/><br/><a href='/'>Volver al inicio</a>\"";
    
  }
$text .= $sl."?>";


$archivo=fopen("../vistas/frontend/main/v".$arrayjson['name']."_list.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);


if ($admin){
  
  //Cambiamos los enlaces
  $text = str_replace("href='/", "href='/admin/", $text);
  
  $archivo=fopen("../vistas/backend/main/v".$arrayjson['name']."_list.php" , "w");
  
  if ($archivo) {
    $result = fputs ($archivo, $text);
  }
  fclose ($archivo);
}


if ($result){
  echo "<font color='green'> &rArr; </font> Vista list creada con &eacute;xito (/vistas/frontend/main/v".$arrayjson['name']."_list.php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando vista list/edit <br />";
}


//***********************************/
//** * * END VISTA LIST *************/
//***********************************/




//***********************************/
//********** * VER VISTA   **********/
//***********************************/
$text = "<?php ". $sl;

$text .= $sl."\$item = \$this->get_var('item');";
$text .= $sl."//#NO-BORRAR#//";

if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= $sl."\$return = \$this->get_var('return');";
}

$text .= $sl.$sl."echo \"<h1>Ver ".$arrayjson['name']."</h1>\"; ".$sl;

foreach ($arrayjson['campos'] as $index => $value ){
  
  switch ($value['type']){
  
    case 'text':
    case 'textarea':
    
      $aux = '';
    
      if ( $value['multilanguage']){
          
        $text .= $sl."echo \"<b>".ucfirst($index."_\".Cutils::get_actual_lng().\"")." :</b> \".\$item['".$index."_'.Cutils::get_actual_lng()].\" <br /><br /> \"; ";  
          
      } else {
        
        $text .= $sl."echo \"<b>".ucfirst($index)." :</b> \".\$item['$index'].\" <br /><br /> \"; ";  
        
      }
      
      break;
      
      
    case 'image':
      
        $text .= $sl."echo \"<b>".ucfirst($index)." :</b> \".Cimagen::show_thumbnail(\$item['$index']).\" <br /><br /> \"; ";  
        
      break;

      
    case 'file':
      
        $text .= $sl."echo \"<b>".ucfirst($index)." :</b> \".Carchivo::show_file(\$item['$index']).\" <br /><br /> \"; ";  
        
      break;
      
    
    default:
      
        $text .= $sl."echo \"<b>".ucfirst($index)." :</b> \".\$item['$index'].\" <br /><br /> \"; ";  
      
      break;
      
  }
  
}
$text .= $sl."echo \"<b>Created :</b> \".\$item['created'].\" <br /><br />\"; ";
$text .= $sl."echo \"<b>Updated :</b> \".\$item['updated'].\" <br /><br />\"; ";


$text .= $sl.$sl."//#NO-BORRAR2#//";

if ( $arrayjson['type'] == 'webform_relational')  {
  $text .= $sl.$sl."echo \"<br /> <a href='/".$arrayjson['name']."/list/\$return/'>\".\$this->translate('return').\"</a>\";  ";
}if ( $arrayjson['type'] == 'webform')  {
  $text .= $sl.$sl."echo \"<br /> <a href='/".$arrayjson['name']."/list/'>\".\$this->translate('return').\"</a>\";  ";
}


$text .= $sl.$sl."?>";

$archivo=fopen("../vistas/frontend/main/v".$arrayjson['name'].".php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $text);
}
fclose ($archivo);

if ($admin){
  
  //Cambiamos los enlaces
  $text = str_replace("href='/", "href='/admin/", $text);
  
  $archivo=fopen("../vistas/backend/main/v".$arrayjson['name'].".php" , "w");
  
  if ($archivo) {
    $result = fputs ($archivo, $text);
  }
  fclose ($archivo);
}

if ($result){
  echo "<font color='green'> &rArr; </font> Vista ver creada con &eacute;xito (/vistas/frontend/main/v".$arrayjson['name'].".php) <br />";
}else{
  echo "<font color='red'> &rArr; </font> Error creando vista ver <br />";
}
//***********************************/
//******** END VER VISTA   **********/
//***********************************/




//***********************************/
//************* HTACCESS   **********/
//***********************************/
$text = $slht.$slht.'#Reglas htaccess para '.$arrayjson['name'];

if ( $arrayjson['type'] == 'webform')  {
  
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create$ /admin/".$arrayjson['name']."/create/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create/$ /admin/".$arrayjson['name']."_create.php [QSA,L] ";
  
  $text .=  $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/list$ /admin/".$arrayjson['name']."/list/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/list/$ /admin/".$arrayjson['name']."_list.php?pag=1 [QSA,L] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([0-9]+)$ /admin/".$arrayjson['name']."_list/$1/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([0-9]+)/$ /admin/".$arrayjson['name']."_list.php?pag=$1 [QSA,L] ";

  $text .=  $slht.$slht."RewriteRule ^".$arrayjson['name']."/list$ /".$arrayjson['name']."/list/ [R] ";
  $text .= $slht."RewriteRule ^".$arrayjson['name']."/list/$ /".$arrayjson['name']."_list.php?pag=1 [QSA,L] ";
  $text .= $slht."RewriteRule ^".$arrayjson['name']."/list/([0-9]+)$ /".$arrayjson['name']."_list/$1/ [R] ";
  $text .= $slht."RewriteRule ^".$arrayjson['name']."/list/([0-9]+)/$ /".$arrayjson['name']."_list.php?pag=$1 [QSA,L] ";
  
  $text .= $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/edit$ /admin/".$arrayjson['name']."/edit/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/$ /admin/".$arrayjson['name']."/list/ [R] ";
  if ( isset($arrayjson['stripped'] ) ) {
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)$ /admin/".$arrayjson['name']."/edit/$1/ [R] ";
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_edit.php?stripped=$1 [QSA,L] ";
  }else{
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([0-9]+)$ /admin/".$arrayjson['name']."/edit/$1/ [R] ";
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([0-9]+)/$ /admin/".$arrayjson['name']."_edit.php?id=$1 [QSA,L] "; 
  }
  
  $text .= $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."$ /admin/".$arrayjson['name']."/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/$ /admin/".$arrayjson['name']."/list/ [R] ";
  if ( isset($arrayjson['stripped'] ) ) {
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)$ /admin/".$arrayjson['name']."/$1/ [R] ";
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/$ /admin/".$arrayjson['name'].".php?stripped=$1 [QSA,L] ";
  }else{
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/([0-9]+)$ /admin/".$arrayjson['name']."/$1/ [R] ";
    $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/([0-9]+)/$ /admin/".$arrayjson['name'].".php?id=$1 [QSA,L] ";  
  }

  $text .= $slht.$slht."RewriteRule ^".$arrayjson['name']."$ /".$arrayjson['name']."/ [R] ";
  $text .= $slht."RewriteRule ^".$arrayjson['name']."/$ /".$arrayjson['name']."/list/ [R] ";
  if ( isset($arrayjson['stripped'] ) ) {
    $text .= $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)$ /".$arrayjson['name']."/$1/ [R] ";
    $text .= $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/$ /".$arrayjson['name'].".php?stripped=$1 [QSA,L] ";
  }else{
    $text .= $slht."RewriteRule ^".$arrayjson['name']."/([0-9]+)$ /".$arrayjson['name']."/$1/ [R] ";
    $text .= $slht."RewriteRule ^".$arrayjson['name']."/([0-9]+)/$ /".$arrayjson['name'].".php?id=$1 [QSA,L] ";  
  }
  
  $text .= $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/delete$ /admin/".$arrayjson['name']."/delete/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/$ /admin/".$arrayjson['name']."/list/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/([0-9]+)$ /admin/".$arrayjson['name']."/delete/$1/ [R] ";
  $text .= $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/([0-9]+)/$ /admin/".$arrayjson['name']."_actions.php?id=$1&a=delete [QSA,L] ";

}else if ( $arrayjson['type'] == 'webform_relational')  {
  
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create$ /admin/".$arrayjson['name']."/create/ [R]  ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create/$ /admin/".$name_of_relation."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create/([a-z0-9-]+)$ /admin/".$arrayjson['name']."_create/$1/ [R] ";
  if (  $arrayjson['relation_stripped']  ) 
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_create.php?stripped=$1 [QSA,L] ";
  else 
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/create/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_create.php?".$name_of_relation."_id=$1 [QSA,L] ";
  
  $text .=  $slht.$slht."RewriteRule ^".$arrayjson['name']."/list$ /".$arrayjson['name']."/list/ [R] ";
  $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/$ /".$name_of_relation."/list/ [R] ";
  $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)$ /".$arrayjson['name']."_list/$1/ [R] ";
  if ( $arrayjson['relation_stripped']  ) {
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/$ /".$arrayjson['name']."_list.php?stripped=$1&pag=1 [QSA,L] ";
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)$ /".$arrayjson['name']."_list/$1/$2/ [R] ";
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)/$ /".$arrayjson['name']."_list.php?stripped=$1&pag=$2 [QSA,L] ";
  }else{
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/$ /".$arrayjson['name']."_list.php?".$name_of_relation."_id=$1&pag=1 [QSA,L] ";
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)$ /".$arrayjson['name']."_list/$1/$2/ [R] ";
    $text .=  $slht."RewriteRule ^".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)/$ /".$arrayjson['name']."_list.php?".$name_of_relation."_id=$1&pag=$2 [QSA,L] ";    
  }

  $text .=  $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/list$ /admin/".$arrayjson['name']."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/$ /admin/".$name_of_relation."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)$ /admin/".$arrayjson['name']."_list/$1/ [R] ";
  if ( $arrayjson['relation_stripped']  ) {
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_list.php?stripped=$1&pag=1 [QSA,L] ";
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)$ /admin/".$arrayjson['name']."_list/$1/$2/ [R] ";
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)/$ /admin/".$arrayjson['name']."_list.php?stripped=$1&pag=$2 [QSA,L] ";
  }else{
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_list.php?".$name_of_relation."_id=$1&pag=1 [QSA,L] ";
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)$ /admin/".$arrayjson['name']."_list/$1/$2/ [R] ";
    $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/list/([a-z0-9-]+)/([0-9]+)/$ /admin/".$arrayjson['name']."_list.php?".$name_of_relation."_id=$1&pag=$2 [QSA,L] ";    
  }
  
  $text .=  $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/edit$ /admin/".$arrayjson['name']."/edit/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/$ /admin/".$arrayjson['name']."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)$ /admin/".$arrayjson['name']."/edit/$1/$2/ [R] ";
  
  if (isset ($arrayjson['stripped']) ) {

     if ( $arrayjson['stripped']  ) {
      
      if (  $arrayjson['relation_stripped']  ) 
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?stripped_id=$1&stripped=$2 [QSA,L] ";
      else
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?".$name_of_relation."_id=$1&stripped=$2 [QSA,L] ";
    
    }else { 
  
      if (  $arrayjson['relation_stripped']  ) 
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?stripped_id=$1&id=$2 [QSA,L] ";
      else
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
    
      }
   
    }else { 
  
      if (  $arrayjson['relation_stripped']  ) 
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?stripped_id=$1&id=$2 [QSA,L] ";
      else
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/edit/([a-z0-9-]+)/([a-z0-9-]+)/$  /admin/".$arrayjson['name']."_edit.php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
    
      }
    
  $text .=  $slht.$slht."RewriteRule ^".$arrayjson['name']."$ /".$arrayjson['name']."/ [R] ";
  $text .=  $slht."RewriteRule ^".$arrayjson['name']."/$ /".$name_of_relation."/list/ [R] ";
  $text .=  $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)$ /".$arrayjson['name']."/$1/$2/ [R] ";
  
  if (isset ($arrayjson['stripped']) ) {

    if ( $arrayjson['stripped']  ) {
      
      if (  $arrayjson['relation_stripped']  ) 
        $text .=  $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /".$arrayjson['name'].".php?stripped_id=$1&stripped=$2 [QSA,L] ";
      else 
        $text .=  $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /".$arrayjson['name'].".php?".$name_of_relation."_id=$1&stripped=$2 [QSA,L] ";
        
    }else{
      $text .=  $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /".$arrayjson['name'].".php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
    }
    
  }else{
      $text .=  $slht."RewriteRule ^".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /".$arrayjson['name'].".php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
    }
  


  $text .=  $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."$ /admin/".$arrayjson['name']."/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/$ /admin/".$name_of_relation."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)$ /admin/".$arrayjson['name']."/$1/$2/ [R] ";

  if (isset ($arrayjson['stripped']) ) {

      if ( $arrayjson['stripped']  ) {
    
        if (  $arrayjson['relation_stripped']  ) 
          $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /admin/".$arrayjson['name'].".php?stripped_id=$1&stripped=$2 [QSA,L] ";
        else 
          $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /admin/".$arrayjson['name'].".php?".$name_of_relation."_id=$1&stripped=$2 [QSA,L] ";
          
      }else{
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /admin/".$arrayjson['name'].".php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
      }
        
  }else{
        $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/([a-z0-9-]+)/([a-z0-9-]+)/$ /admin/".$arrayjson['name'].".php?".$name_of_relation."_id=$1&id=$2 [QSA,L] ";
      }
  
     
  $text .=  $slht.$slht."RewriteRule ^admin/".$arrayjson['name']."/delete$ /admin/".$arrayjson['name']."/delete/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/$ /admin/".$arrayjson['name']."/list/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/([a-z0-9-]+)/([a-z0-9-]+)$ /admin/".$arrayjson['name']."/delete/$1/$2/ [R] ";
  $text .=  $slht."RewriteRule ^admin/".$arrayjson['name']."/delete/([a-z0-9-]+)/([a-z0-9-]+)/$ /admin/".$arrayjson['name']."_actions.php?".$name_of_relation."_id=$1&id=$2&a=delete [QSA,L] ";

  
}
$text .= $slht.'#Fin reglas htaccess para '.$arrayjson['name'];

if ($htaccess){
  $archivo=fopen("../.htaccess" , "a");
  if ($archivo) {
    $result = fputs ($archivo, $text);
  }
  fclose ($archivo);
  
  echo "<br/><b>Htaccess</b> </br>";
  
  if ($result){
    echo "<font color='green'> &rArr; </font> .htaccess modificado con &eacute;xito (/.htaccess) <br />";
  }else{
    echo "<font color='red'> &rArr; </font> Error creando .htaccess <br />";
  }
}

//***********************************/
//******** END HTACCESS   ***********/
//***********************************/





//***********************************/
//******** CAMBIOS EN VTOP   ********/
//***********************************/

$top = $sl.$tab.$tab."//#NO-BORRAR#//";

$top .= $sl.$sl.$tab.$tab."case '".$arrayjson['name']."':";

if ( $arrayjson['type'] == 'webform_relational')  {

  if ( isset($arrayjson['stripped']) ) {
    
    if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
      
          $top .= $sl.$sl.$tab.$tab.$tab."//CASO MULTILENGUAJE Y STRIPPED";
          
          $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
          
          $top .= $sl.$sl.$tab.$tab.$tab."if (\$explode_uri[2] == 'list' or \$explode_uri[2] == 'create'){ ";
            
            $top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\";";
            
            $top .= $sl.$tab.$tab.$tab.$tab."\$stripped = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid'));";
            
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_es'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_ca'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_en'].\"/\"; ";
            
            
          $top .= $sl.$sl.$tab.$tab.$tab."}else if (\$explode_uri[2] == 'edit'){ ";
            
            $top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
           
            $top .= $sl.$tab.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$stripped = C".$arrayjson['name']."::get_strippeds(\$explode_uri[4], \$this->get_var('rid')); ";
            
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped['stripped_es'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped['stripped_ca'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped['stripped_en'].\"/\"; ";
           
          $top .= $sl.$sl.$tab.$tab.$tab."}else{ ";
            
            $top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\"; ";
            
            $top .= $sl.$tab.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[2], \$this->get_var('rid')); ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$stripped = C".$arrayjson['name']."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
            
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped['stripped_es'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped['stripped_ca'].\"/\"; ";
            $top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped['stripped_en'].\"/\"; ";
          $top .= $sl.$tab.$tab.$tab."}";
          
          
          $top .= $sl.$sl.$tab.$tab.$tab."echo \"<div class='rfloat'> \"; ";
            $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_es'>ES</a> - \"; ";
            $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_ca'>CA</a> - \"; ";
            $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_en'>EN</a> \"; ";
          $top .= $sl.$tab.$tab.$tab."echo \"</div>\"; ";
          
          $top .= $sl.$sl.$tab.$tab.$tab."break;";
          
          // FIN CASO MULTILENGUAJE Y STRIPPED
      
    }else{


      $top .= $sl.$sl.$tab.$tab.$tab."//CASO SIN MULTILENGUAJE Y STRIPPED";
      
      $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
      
      $top .= $sl.$sl.$tab.$tab.$tab."if (\$explode_uri[2] == 'list' or \$explode_uri[2] == 'create'){ ";
        
        $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
        
        $top .= $sl.$tab.$tab.$tab."\$stripped = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
        
        $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_es'].\"/\"; ";
        $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_ca'].\"/\"; ";
        $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_en'].\"/\"; ";
        
        
      $top .= $sl.$sl.$tab.$tab.$tab."}else if (\$explode_uri[2] == 'edit'){ ";
        
        $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
       
        $top .= $sl.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
        $top .= $sl.$tab.$tab.$tab."\$stripped = \$explode_uri[4]; ";
        
        $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped.\"/\";";
        $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped.\"/\";";
        $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped.\"/\";";
       
      $top .= $sl.$sl.$tab.$tab.$tab."}else{";
        
        $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\";";
        
        $top .= $sl.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[2], \$this->get_var('rid'));";
        $top .= $sl.$tab.$tab.$tab."\$stripped = \$explode_uri[3];";
        
        $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped.\"/\";";
        $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped.\"/\";";
        $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped.\"/\";";
      $top .= $sl.$sl.$tab.$tab.$tab."}"; 
      
      
      $top .= $sl.$sl.$tab.$tab.$tab."echo \"<div class='rfloat'> \"; ";
        $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_es'>ES</a> - \"; ";
        $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_ca'>CA</a> - \"; ";
        $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_en'>EN</a> \"; ";
      $top .= $sl.$tab.$tab.$tab."echo \"</div>\"; ";  
      
      $top .= $sl.$sl.$tab.$tab.$tab."break;";
      
      $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO SIN MULTILENGUAJE Y STRIPPED";
          
          
    } //fi $arrayjson['campos'][$arrayjson['stripped']]['multilanguage']
    
  }else{ //fi isset($arrayjson['stripped']) )

    $top .= $sl.$sl.$tab.$tab.$tab."//CASO SIN MULTILENGUAJE Y SIN STRIPPED (IGUAL QUE EL ANTERIOR)";
          
    $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
    
    $top .= $sl.$sl.$tab.$tab.$tab."if (\$explode_uri[2] == 'list' or \$explode_uri[2] == 'create'){";
      
      $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
      
      $top .= $sl.$tab.$tab.$tab."\$stripped = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
      
      $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_es'].\"/\"; ";
      $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_ca'].\"/\"; ";
      $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_en'].\"/\"; ";
      
      
    $top .= $sl.$sl.$tab.$tab.$tab."}else if (\$explode_uri[2] == 'edit'){";
      
      $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\"; ";
     
      $top .= $sl.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
      $top .= $sl.$tab.$tab.$tab."\$stripped = \$explode_uri[4]; ";
      
      $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped.\"/\";";
      $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped.\"/\";";
      $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped.\"/\";";
     
    $top .= $sl.$sl.$tab.$tab.$tab."}else{";
      
      $top .= $sl.$sl.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\";";
      
      $top .= $sl.$tab.$tab.$tab."\$stripped_relational = C".$name_of_relation."::get_strippeds(\$explode_uri[2], \$this->get_var('rid'));";
      $top .= $sl.$tab.$tab.$tab."\$stripped = \$explode_uri[3];";
      
      $top .= $sl.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_es'].\"/\".\$stripped.\"/\";";
      $top .= $sl.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_ca'].\"/\".\$stripped.\"/\";";
      $top .= $sl.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped_relational['stripped_en'].\"/\".\$stripped.\"/\";";
    $top .= $sl.$sl.$tab.$tab.$tab."}";              
    
    $top .= $sl.$sl.$tab.$tab.$tab."echo \"<div class='rfloat'> \"; ";
      $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_es'>ES</a> - \"; ";
      $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_ca'>CA</a> - \"; ";
      $top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_en'>EN</a> \"; ";
    $top .= $sl.$tab.$tab.$tab."echo \"</div>\"; ";  
    
    $top .= $sl.$sl.$tab.$tab.$tab."break;";
    
    $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO SIN MULTILENGUAJE Y SIN STRIPPED";
  }  

}else if ( $arrayjson['type'] == 'webform'){
  
  if ( isset($arrayjson['stripped']) ) {
    
    if ($arrayjson['campos'][$arrayjson['stripped']]['multilanguage'] ){
          

			$top .= $sl.$sl.$tab.$tab.$tab."//CASO MULTILENGUAJE Y STRIPPED";

			$top .= $sl.$sl.$tab.$tab.$tab."if (\$explode_uri[2] == 'edit'){ ";

				$top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\";";

				$top .= $sl.$tab.$tab.$tab.$tab."\$stripped = C".$arrayjson['name']."::get_strippeds(\$explode_uri[3], \$this->get_var('rid')); ";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_es'].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_ca'].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_en'].\"/\";"; 
				
			$top .= $sl.$sl.$tab.$tab.$tab."}else if (\$explode_uri[2] == 'create' or \$explode_uri[2] == 'list'){ ";
			  
  			$top .= $sl.$sl.$tab.$tab.$tab.$tab."echo \"<div class='rfloat'>\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://www.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>ES</a> -\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://ca.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>CA</a> -\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://en.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>EN</a> \"; ";
        $top .= $sl.$tab.$tab.$tab.$tab."echo \"</div>\";";
        
        $top .= $sl.$sl.$tab.$tab.$tab.$tab."break;";
			  
			$top .= $sl.$sl.$tab.$tab.$tab."}else{"; 

				$top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$stripped = C".$arrayjson['name']."::get_strippeds(\$explode_uri[2], \$this->get_var('rid')); ";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_es'].\"/\"; ";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_ca'].\"/\";"; 
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$stripped['stripped_en'].\"/\";";
			$top .= $sl.$sl.$tab.$tab.$tab."}";

			$top .= $sl.$sl.$tab.$tab.$tab."echo \"<div class='rfloat'> \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_es'>ES</a> - \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_ca'>CA</a> - \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_en'>EN</a> \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"</div>\"; ";

			$top .= $sl.$sl.$tab.$tab.$tab."break;";

      $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO MULTILENGUAJE Y STRIPPED ";

    }else{
      
      $top .= $sl.$sl.$tab.$tab.$tab."//CASO SIN MULTILENGUAJE Y STRIPPED";
      
			$top .= $sl.$sl.$tab.$tab.$tab."if (\$explode_uri[2] == 'edit'){ ";

				$top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\".\$explode_uri[2].\"/\";";

				$top .= $sl.$sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[3].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[3].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[3].\"/\";"; 
				
			$top .= $sl.$sl.$tab.$tab.$tab."}else if (\$explode_uri[2] == 'create' or \$explode_uri[2] == 'list'){ ";
			  
  			$top .= $sl.$sl.$tab.$tab.$tab.$tab."echo \"<div class='rfloat'>\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://www.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>ES</a> -\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://ca.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>CA</a> -\"; ";
          $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://en.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>EN</a> \"; ";
        $top .= $sl.$tab.$tab.$tab.$tab."echo \"</div>\";";
        
        $top .= $sl.$sl.$tab.$tab.$tab.$tab."break;";
			  
			$top .= $sl.$sl.$tab.$tab.$tab."}else{"; 

				$top .= $sl.$sl.$tab.$tab.$tab.$tab."\$new_uri = \"/\".\$explode_uri[1].\"/\";";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_es = \"http://www.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[2].\"/\"; ";
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_ca = \"http://ca.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[2].\"/\";"; 
				$top .= $sl.$tab.$tab.$tab.$tab."\$url_en = \"http://en.\".DOMAIN.\"\".\$new_uri.\"\".\$explode_uri[2].\"/\";";
			$top .= $sl.$sl.$tab.$tab.$tab."}";

			$top .= $sl.$sl.$tab.$tab.$tab."echo \"<div class='rfloat'> \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_es'>ES</a> - \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_ca'>CA</a> - \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"<a href='\$url_en'>EN</a> \"; ";
			$top .= $sl.$tab.$tab.$tab."echo \"</div>\"; ";

			$top .= $sl.$sl.$tab.$tab.$tab."break;";
      
      $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO SIN MULTILENGUAJE Y STRIPPED ";
    }
  }else{
    
    $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO SIN MULTILENGUAJE Y SIN STRIPPED ";
    
  	$top .= $sl.$sl.$tab.$tab.$tab.$tab."echo \"<div class='rfloat'>\"; ";
      $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://www.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>ES</a> -\"; ";
      $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://ca.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>CA</a> -\"; ";
      $top .= $sl.$tab.$tab.$tab.$tab."echo \"<a href='http://en.\".DOMAIN.\"\".\$_SERVER['REQUEST_URI'].\"'>EN</a> \"; ";
    $top .= $sl.$tab.$tab.$tab.$tab."echo \"</div>\";";
    
    $top .= $sl.$sl.$tab.$tab.$tab."break;";
    
    $top .= $sl.$sl.$tab.$tab.$tab."//FIN CASO SIN MULTILENGUAJE Y SIN STRIPPED ";
    
  }
  
}



$file = file_get_contents(PATH_ROOT."vistas/frontend/top/vtop.php");
$new_file = str_replace('//#NO-BORRAR#//', $top, $file);


$archivo=fopen("../vistas/frontend/top/vtop.php" , "w");
if ($archivo) {
  $result = fputs ($archivo, $new_file);
}
fclose ($archivo);

  echo "<br/><b>Modificacion vtop (idiomas)</b> </br>";
  
  if ($result){ 
    echo "<font color='green'> &rArr; </font> vtop modificado con &eacute;xito (/vistas/frontend/top/vtop.php) <br />";
  }else{
    echo "<font color='red'> &rArr; </font> Error modificando vtop.php <br />";
  }

//***********************************/
//******** FIN CAMBIOS EN VTOP*******/
//***********************************/




//***********************************/
//******** Aviso cambios  ***********/
//***********************************/

if ($cambios){
  
  if ( $arrayjson['type'] == 'webform_relational')  {
    
  
    echo "<br/><b>Cambios realizados en tu c&oacute;digo</b> </br>";
    
    echo "<ul>";
    
      //añadimos la clase
      $file = file_get_contents(PATH_ROOT.$name_of_relation."_list.php");
      $new_file = str_replace('//#NO-BORRAR#//', "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');\n //#NO-BORRAR#//", $file);
      
      
      $archivo=fopen(PATH_ROOT.$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
  
      if ($result){ 
        echo "<li>En <u>".$name_of_relation."_list.php</u> a&ntilde;adido <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      }else{
        echo "<li>Error en <u>".$name_of_relation."_list.php</u> en a&ntilde;adir <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      }
      
      //admin
      $file = file_get_contents(PATH_ROOT."/admin/".$name_of_relation."_list.php");
      $new_file = str_replace('//#NO-BORRAR#//', "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');\n //#NO-BORRAR#//", $file);
      
      $archivo=fopen(PATH_ROOT."/admin/".$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
  
      if ($result){ 
        echo "<li>En <u>/admin/".$name_of_relation."_list.php</u> a&ntilde;adido <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      }else{
        echo "<li>Error en <u>".$name_of_relation."_list.php</u> en a&ntilde;adir <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      }
      
      
      //Cambiamos el colspan de la vista del listado
      $file = file_get_contents(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation."_list.php");
      $new_file = str_replace('<th colspan=\'3\'>', '<th colspan=\'4\'>', $file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
      
      if ($result)
        echo "<li>En <u> frontend/v".$name_of_relation."_list.php</u> cambiado el colspan de opciones a 4</li>";
      else 
        echo "<li>Error en <u> v".$name_of_relation."_list.php</u> cambiando el colspan de opciones a 4</li>";
      
      
      //admin
      $file = file_get_contents(PATH_ROOT."/vistas/backend/main/v".$name_of_relation."_list.php");
      $new_file = str_replace('<th colspan=\'3\'>', '<th colspan=\'4\'>', $file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/backend/main/v".$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
      
      if ($result)
        echo "<li>En <u> backend/v".$name_of_relation."_list.php</u> cambiado el colspan de opciones a 4</li>";
      else 
        echo "<li>Error en <u> v".$name_of_relation."_list.php</u> cambiando el colspan de opciones a 4</li>";
      
  
  
      //Añadimos una columna a la vista
      
      if (  $arrayjson['relation_stripped']) {
         if ( $arrayjson['relation_multilang'] )
           $aux = "echo \"<td><a href='/".$arrayjson['name']."/list/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\";\n //#NO-BORRAR#// "; 
         else 
           $aux = "echo \"<td><a href='/".$arrayjson['name']."/list/\".\$item['stripped'].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\";\n //#NO-BORRAR#// "; 
       }else
        $aux = "echo \"<td><a href='/".$arrayjson['name']."/list/\".\$item['id'].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\"; \n //#NO-BORRAR#//\"; "; 
      
      
      $file = file_get_contents(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation."_list.php");
      $new_file = str_replace('//#NO-BORRAR#//', $aux, $file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
          
      if ($result)
        echo "<li>En <u> frontend/v".$name_of_relation."_list.php</u> a&ntilde;adida esta columna en las opciones <br>$tab<i>".htmlentities($aux)."</i> </li>";      
      else 
        echo "<li>Error en <u> v".$name_of_relation."_list.php</u> a&ntilde;adiendo esta columna en las opciones <br>$tab<i>".htmlentities($aux)."</i> </li>";
        
      
      //admin
          
      if ( $arrayjson['relation_stripped'] ) {
        if ( $arrayjson['relation_multilang'] )  
          $aux = "echo \"<td><a href='/admin/".$arrayjson['name']."/list/\".\$item['stripped_'.Cutils::get_actual_lng()].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\";\n //#NO-BORRAR#// "; 
        else
          $aux = "echo \"<td><a href='/admin/".$arrayjson['name']."/list/\".\$item['stripped'].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\";\n //#NO-BORRAR#// "; 
        
      } else
        $aux = "echo \"<td><a href='/admin/".$arrayjson['name']."/list/\".\$item['id'].\"/'>Link a ".$arrayjson['name']." (\".C".$arrayjson['name']."::count_".$arrayjson['name']."(\$item['id']).\")</a></td>\"; \n //#NO-BORRAR#//\"; "; 
      
      
      $file = file_get_contents(PATH_ROOT."/vistas/backend/main/v".$name_of_relation."_list.php");
      $new_file = str_replace('//#NO-BORRAR#//', $aux, $file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/backend/main/v".$name_of_relation."_list.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
      
      if ($result)
        echo "<li>En <u> backend/v".$name_of_relation."_list.php</u> a&ntilde;adida esta columna en las opciones <br>$tab<i>".htmlentities($aux)."</i> </li>";      
      else 
        echo "<li>Error en <u> v".$name_of_relation."_list.php</u> a&ntilde;adiendo esta columna en las opciones <br>$tab<i>".htmlentities($aux)."</i> </li>";
        
        
       //en ver añadimos las relaciones
       //añadimos la clase y añadimos la llamada para obtener las relaciones
      $file = file_get_contents(PATH_ROOT."/".$name_of_relation.".php");
      $new_file = str_replace('//#NO-BORRAR#//', "require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');\n", $file);
      $new_file = str_replace('//#NO-BORRAR2#//', "\$layout->set_var('relation_list', C".$arrayjson['name']."::item_list(\$id, ''));", $new_file);
      
      
      $archivo=fopen(PATH_ROOT.$name_of_relation.".php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
  
      if ($result){ 
        echo "<li>En <u>".$name_of_relation.".php</u> a&ntilde;adido <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> y añadida variable para pasar a vista con el listado de relaciones </li>";
      }else{
        echo "<li>Error en <u>".$name_of_relation.".php</u> en a&ntilde;adir <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      } 
      
       //añadimos las relaciones en la vista
      $file = file_get_contents(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation.".php");
      $new_file = str_replace('//#NO-BORRAR#//', "\$relation_list = \$this->get_var('relation_list');\n", $file);
      
      $new_text = "echo \"<h2>Relaciones</h2>\";";
      
      
      $new_text .= $sl.$sl."if (\$relation_list['total']){ ";
      
       $new_text .= $sl.$sl.$tab."echo \"Total de relaciones: \".\$relation_list['total'].\"<br/>\"; ";
      
      $new_text .= $sl.$sl.$tab."foreach (\$relation_list['item'] as \$relation){ ";
      
           foreach ($arrayjson['campos'] as $index => $value ){ 
             
            if ( isset($value['multilanguage'])){
              
              if ( $value['multilanguage']){
                $new_text .= $sl.$tab.$tab."echo  \$relation['".$index."_'.Cutils::get_actual_lng()] .\" -- \";";  
              }else {
                $new_text .= $sl.$tab.$tab."echo  \$relation['$index'].\" -- \";"; 
              }
              
            } else {
              $new_text .= $sl.$tab.$tab."echo  \$relation['$index'].\" -- \";"; 
            }
              
           } 
          $new_text .= $sl.$tab.$tab."echo \"<br />\" ;"; 

        $new_text .= $sl.$tab."}";
      $new_text .= $sl."}else{";
      $new_text .= $sl.$tab."echo \"No existen relaciones.<br/>\";";
      $new_text .= $sl."}";
      $new_file = str_replace('//#NO-BORRAR2#//', $new_text, $new_file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/frontend/main/v".$name_of_relation.".php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
  
      if ($result){ 
        echo "<li>En <u>".$name_of_relation.".php</u> a&ntilde;adido <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> y añadida variable para pasar a vista con el listado de relaciones </li>";
      }else{
        echo "<li>Error en <u>".$name_of_relation.".php</u> en a&ntilde;adir <i>require_once(PATH_ROOT_CLASES . 'c".$arrayjson['name'].".php');</i> </li>";
      }         
      
    echo "</ul>";
    
  }else{
      echo "<br/><b>Cambios realizados en tu c&oacute;digo</b> </br>";
    
      echo "<ul>";
    
      //Añadimos una opcion al menu de admin
       
      $file = file_get_contents(PATH_ROOT."/vistas/backend/main/vadmin_index.php");
      $new_file = str_replace('//#NO-BORRAR#//', "echo \"<li><a href='/admin/".$arrayjson['name']."/list/'>Gestión de ".$arrayjson['name']."</a></li>\";\n//#NO-BORRAR#//", $file);
      
      
      $archivo=fopen(PATH_ROOT."/vistas/backend/main/vadmin_index.php" , "w");
      if ($archivo) {
        $result = fputs ($archivo, $new_file);
      }
      fclose ($archivo);
  
      if ($result){ 
        echo "<li>En <u>/backend/main/vadmin_index.php</u> a&ntilde;adido elemento en el menu</li>";
      }else{
        echo "<li>Error en <u>/backend/main/vadmin_index.php</u> en a&ntilde;adir el elemento en el menu </i> </li>";
      } 
      
      echo "</ul>"; 
    
  }
  
}


//***********************************/
//********fin Aviso cambios   *******/
//***********************************/

echo "<br /><a href='/scaffolds/'>Volver</a>";


  function Conecta() {
    
    if (DBDRIVER == "postgresql"){
    
      $connect_string = "host='".HOST."' user='".USER."' password='".PASSWORD."' dbname='".DBNAME."'";
      $con = @pg_connect($connect_string);
  
      return $con;
    
    }else if (DBDRIVER == "mysql"){
      
      $link = mysql_connect('localhost', 'root', 'root');
      mysql_select_db(DBNAME);
      
      
      if (!$link){
        die("No s'ha pogut connectar al servidor MySQL.");
      }
     
      return $link;
    }
  }

?> 