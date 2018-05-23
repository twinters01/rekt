<?php
  //DB Params
  define('DB_HOST','localhost');
  define('DB_USER','root');
  define('DB_PASS','pass');
  define('DB_NAME','rekt');

  //App root
  define('APPROOT',dirname(dirname(__FILE__)));
  //URL Root
  define('URLROOT','http://localhost/rekt');
  //Site Name
  define('SITENAME','Rekt');
  //App version
  define('APPVERSION','1.0.0');

  //Other configs
  define('USER_MINPASSLEN',6);
  define('USER_MAXPASSLEN',20);
  define('USER_MINUSERNAMELEN',4);
  define('USER_MAXUSERNAMELEN',20);

  //Type and status variable definitions
  define('REQUEST_TYPE_FRIEND','f');
  define('REQUEST_TYPE_CHALLENGE','c');
  define('REQUEST_TYPE_REPORT','r');

  define('REQUEST_STATUS_APPROVED','a');
  define('REQUEST_STATUS_PENDING','p');
  define('REQUEST_STATUS_IGNORED','i');
  define('REQUEST_STATUS_REJECTED','r');

 ?>
