<?php   $session = $this->get_session();    if($session->check(true)){        echo "Identificado como ".$this->get_session()->get_var_session('name')." <a href='/logout/'>logout</a>";      }else{        if ($this->getMain() != "vlogin")      echo "<a href='/login/'>login</a>";  }  $explode_uri = explode('/',  $_SERVER['REQUEST_URI']);  switch($explode_uri[1]){        //#NO-BORRAR#//    default:        echo "<div class='rfloat'>";      echo "<a href='http://www.".DOMAIN."".$_SERVER['REQUEST_URI']."'>ES</a> -";       echo "<a href='http://ca.".DOMAIN."".$_SERVER['REQUEST_URI']."'>CA</a> -";       echo "<a href='http://en.".DOMAIN."".$_SERVER['REQUEST_URI']."'>EN</a> ";     echo "</div>";        break;      } ?>