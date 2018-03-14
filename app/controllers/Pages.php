<?php
  class Pages extends Controller{
    public function __construct()
    {
      $this->viewdir = 'pages';
    }

    public function index()
    {
      $data = ['title'=>'Welcome'];
      $this->view('index',$data);
    }

    public function about()
    {
      $data = ['title'=>'About Us'];
      $this->view('about', $data);
    }
  }
 ?>
