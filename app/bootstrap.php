<?php
  //Load config
  require_once 'config/config.php';

  //Load helpers
  require_once 'helpers/session_helper.php';
  require_once 'helpers/url_helper.php';
  require_once 'helpers/debug_helper.php';

  //Autoload Core Libraries
  spl_autoload_register(function($classname)
  {
    require_once 'lib/'.$classname.'.php';
  })
 ?>
