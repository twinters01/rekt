<?php
/*
  Core app class
  Creates URL and loads core controller
  URL format: /controller/method/params
*/

class Core{
  //Default controller will be Pages
  protected $currentController = 'Pages';
  //Default method will be index
  protected $currentMethod = 'index';
  //Params will start off empty
  protected $params = [];

  public function __construct(){
    //print_r($this->getUrl());
    $url = $this->getUrl();

    //Find the correct controller
    if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
      //Set the current controller if we found the correct controller
      $this->currentController = ucwords($url[0]);
      //Delete the controller off of the url array
      unset($url[0]);
    }
    
    //Instantiate the controller
    require_once '../app/controllers/'.$this->currentController.'.php';
    $this->currentController = new $this->currentController;

    //Check for a required method
    if(isset($url[1])){
      //Check if the method exists in the controller
      if(method_exists($this->currentController,$url[1])){
        $this->currentMethod = $url[1];
        unset($url[1]);
      }
    }

    //Get any remaining values as params
    $this->params = $url ? array_values($url) : [];

    //Call the method on the controller with the params
    call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
  }

  public function getUrl(){
    //Make sure we have a URL
    if(isset($_GET['url'])){
      //Get the URL, right-trimmed
      $url = rtrim($_GET['url'],'/');
      //Sanitize the URL to make it a valid URL
      $url = filter_var($url, FILTER_SANITIZE_URL);
      //Split the url by '/'
      $url = explode('/',$url);

      return $url;
    }
  }
}
 ?>
