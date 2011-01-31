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
  
    echo "<input type='text' name='model' />";
    echo "<input type='submit' value='Borrar'>";
    
  echo "</form>";
  
  
  if ( isset($_REQUEST['model']) ){
    
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
  
  
  ?>
</body>
</html>