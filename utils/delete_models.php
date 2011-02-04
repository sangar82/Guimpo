<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Delete Models</title>
</head>
<body>
  <H2>Delete models</H2>
  
  <?php
  
  require_once("../config.php");
  require_once(PATH_ROOT_CLASES."/cdatabase.php");
   
  
  
  echo "<form>";
  
    //echo "<input type='text' name='model' /><br/>";
    
    echo "Escoge el modelo a borrar &nbsp;&nbsp;";
    
    echo "<select name='model'>";
    
      $imagenes =  glob(PATH_ROOT."/clases/{cform_construct_*.php}",GLOB_BRACE);
  
      foreach ($imagenes as $ima){
        
        $aux = explode("_", $ima);
        
        if ( count($aux) == 3)
          $aux2 = explode(".", $aux[count($aux) - 1]);
        else if (count($aux) == 4)
          $aux2 = explode(".", $aux[count($aux) - 2]."_".$aux[count($aux) - 1] );
        
        if ($aux2[0] != "user"  and  $aux2[0] != "login") 
          echo "<option value='".$aux2[0]."'>".$aux2[0]."</option>";
        
      }
    
    echo "</select><br /><br />";
    
    echo "<input type='checkbox' value='1' name='restore' id='restore'>  <label for='restore'>Restaurar archivos</label> <br/><br/>";
    
    echo "<input type='hidden' name='send' value='1' />";
    
    echo "<input type='submit' value='Borrar'>";
    
  echo "</form>";
  
  
  $model = isset($_REQUEST['model']) ?  $_REQUEST['model']  :  "";
  $restore = isset($_REQUEST['restore']) ?  $_REQUEST['restore']  :  "0";
  $send   = isset($_REQUEST['send']) ?  $_REQUEST['send']  :  "0";
    
  if ($model){
    
    unlink(PATH_ROOT . "/clases/c".$_REQUEST['model'].".php");
    unlink(PATH_ROOT . "/clases/cform_construct_".$_REQUEST['model'].".php");
    
    unlink(PATH_ROOT . "/".$_REQUEST['model'].".php");
    unlink(PATH_ROOT . "/".$_REQUEST['model']."_list.php");
    
    unlink(PATH_ROOT . "/admin/".$_REQUEST['model'].".php");
    unlink(PATH_ROOT . "/admin/".$_REQUEST['model']."_list.php");
    unlink(PATH_ROOT . "/admin/".$_REQUEST['model']."_edit.php");
    unlink(PATH_ROOT . "/admin/".$_REQUEST['model']."_create.php");
    unlink(PATH_ROOT . "/admin/".$_REQUEST['model']."_actions.php");
    
    unlink(PATH_ROOT . "/vistas/backend/main/v".$_REQUEST['model']."_list.php");
    unlink(PATH_ROOT . "/vistas/backend/main/v".$_REQUEST['model']."_create.php");
    unlink(PATH_ROOT . "/vistas/backend/main/v".$_REQUEST['model'].".php"); 
  
    unlink(PATH_ROOT . "/vistas/frontend/main/v".$_REQUEST['model']."_list.php");
    unlink(PATH_ROOT . "/vistas/frontend/main/v".$_REQUEST['model'].".php");
    
    //borramos la tabla de la base de datos
    $con = new cdatabase(array('host'=>HOST, 'user'=>USER, 'dbname'=>DBNAME, 'password'=>PASSWORD), DBDRIVER );
    
    $query = "drop table ".$_REQUEST['model'].";";

    $item = $con->drop($query);
  }
  
  
  if ($restore){
    copy(PATH_ROOT . "/utils/temp/vtop.php", PATH_ROOT . "/vistas/frontend/top/vtop.php")  ;
    copy(PATH_ROOT . "/utils/temp/vadmin_index.php", PATH_ROOT . "/vistas/backend/main/vadmin_index.php")  ;
    copy(PATH_ROOT . "/utils/temp/.htaccess", PATH_ROOT . "/.htaccess")  ;
    
    //borramos las migraciones
    $archivos =  glob(PATH_ROOT."/bd/migrations/{migration_*}",GLOB_BRACE);
    
    foreach ($archivos as $archivo){
      if ($archivo != PATH_ROOT."/bd/migrations/migration_01_users.sql" )
        unlink ($archivo);
    }
    
    //borramos las posibles imagenes subidas
    eliminar_recursivo_contenido_de_directorio(PATH_ROOT."/img/uploads");
    
    //creamos la carpeta de subidas de ckeditor
    mkdir(PATH_ROOT."/img/uploads/ckeditor");
    
  }
  
  if ($send){
    echo "<script>document.location = '/utils/delete_models.php'</script>";
  }

  function eliminar_recursivo_contenido_de_directorio($carpeta){
    
    $directorio = opendir($carpeta);
    
    while ($archivo = readdir($directorio)){
      
      if( $archivo !='.' && $archivo !='..' ){ //comprobamos si es un directorio o un archivo
        
        if ( is_dir( $carpeta.'/'.$archivo ) ){
          
          //si es un directorio, volvemos a llamar a la función para que elimine el contenido del mismo
          eliminar_recursivo_contenido_de_directorio( $carpeta.'/'.$archivo );
          rmdir($carpeta.'/'.$archivo); //borrar el directorio cuando esté vacío
        
        }
        else //si no es un directorio, lo borramos
          unlink($carpeta.'/'.$archivo);
          
      }
    }
    closedir($directorio);
  } 
  
  ?>
</body>
</html>