<?php
  /*
    Base controller - Loads models and views
  */

  class Controller{
    //Directory to views, do not include preceding/trailing '/' characters
    protected $viewdir = '';
    //Directory to models, do not include preceding/trailing '/' characters
    protected $modeldir = '';

    public function model($model)
    {
      require_once '../app/models/'.$model.'.php';
      return new $model();
    }

    public function view($view,$data)
    {
      $path = '../app/views/'.$this->viewdir.'/'.$view.'.php';

      if(file_exists($path))
      {
        require_once $path;
      }
      else
      {
        die('View does not exist');
      }
    }
  }

 ?>
