<?php
//Redirect to a page
function redirect($url){
  header('location: '.URLROOT.'/'.$url);
}

function flashRedirect($url,$name='',$message='',$class='alert alert-success')
{
  flash($name,$message,$class);
  redirect($url);
}
 ?>
