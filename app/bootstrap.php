<?php
  //Load config
  require_once 'config/config.php';

  //Autoload Core Libraries
  spl_autoload_register(function($classname)
  {
    require_once 'lib/'.$classname.'.php';
  })
 ?>
