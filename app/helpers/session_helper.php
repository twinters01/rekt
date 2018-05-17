<?php
  session_start();

  function flash($name='',$message='',$class='alert alert-success')
  {
    if(!empty($name))
    {
      if(!empty($message) && empty($_SESSION[$name]))
      {
        //Unset session variables if they already exist
        if(!empty($_SESSION['name']))
        {
          unset($_SESSION['name']);
        }
        if(!empty($_SESSION[$name.'_class']))
        {
          unset($_SESSION[$name.'_class']);
        }

        //Set name and class
        $_SESSION[$name] = $message;
        $_SESSION[$name.'_class'] = $class;
      }elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';

        //Build the div to be displayed
        $val = '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';

        unset($_SESSION[$name]);
        unset($_SESSION[$name.'_class']);

        //Display the div
        echo $val;
      }
    }
  }

  //Check if a user is logged in
  function isLoggedIn()
  {
    return isset($_SESSION['user_id']);
  }

  //Checks if a user id matches the current logged in user
  function checkUser($id)
  {
    return $_SESSION['user_id'] == $id;
  }

  //Returns a dictionary of the currently logged in user
  function getUser()
  {
    return ['name'=>$_SESSION['user_name'],'id'=>$_SESSION['user_id'],'email'=>$_SESSION['user_email']];
  }
 ?>
