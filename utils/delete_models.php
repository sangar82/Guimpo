<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Delete Models</title>
</head>
<body>
  <H2>Delete models</H2>
  
  <?php
  
  require_once("../config.php");
   
  
  
  echo "<form>";
  
    //echo "<input type='text' name='model' /><br/>";
    
    echo "Escoge el modelo a borrar &nbsp;&nbsp;";
    
    echo "<select name='model'>";
    
      $imagenes =  glob(PATH_ROOT."/clases/{cform_construct_*.php}",GLOB_BRACE);
  
      foreach ($imagenes as $ima){
        
        $aux = explode("_", $ima);
        
        $aux2 = explode(".", $aux[count($aux) - 1]);
        
        if ($aux2[0] != "user"  and  $aux2[0] != "login") 
          echo "<option value='".$aux2[0]."'>".$aux2[0]."</option>";
        
      }
    
    echo "</select><br /><br />";
    
    echo "<input type='checkbox' value='1' name='restore'>  &nbsp;  Restaurar archivos <br/><br/>";
    
    echo "<input type='submit' value='Borrar'>";
    
  echo "</form>";
  
  
  $model = isset($_REQUEST['model']) ?  $_REQUEST['model']  :  "";
    
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
  }
  
  $restore = isset($_REQUEST['restore']) ?  $_REQUEST['restore']  :  "0";
  
  if ($restore){
    copy(PATH_ROOT . "/utils/temp/vtop.php", PATH_ROOT . "/vistas/frontend/top/vtop.php")  ;
    copy(PATH_ROOT . "/utils/temp/vadmin_index.php", PATH_ROOT . "/vistas/backend/main/vadmin_index.php")  ;
    copy(PATH_ROOT . "/utils/temp/.htaccess", PATH_ROOT . "/.htaccess")  ;
  }
  
  ?>
</body>
</html>