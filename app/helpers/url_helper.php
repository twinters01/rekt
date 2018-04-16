<?php
//Redirect to a page
function redirect($url){
  header('location: '.URLROOT.'/'.$url);
}
 ?>
