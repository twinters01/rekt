<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->deckModel = $this->model('Deck');
  }
  public function index()
  {
    redirect('404');
  }
  public function register()
  {
    //Check for request type

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      //Sanitize input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data=[
        'username' => trim($_POST['username']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name' => trim($_POST['name']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
        'name_err' => ''
      ];

      //Check for existing users
      $result = $this->userModel->findUserByUsernameOrEmail($data['username'],$data['email']);

      foreach($result as $u){
        if($data['username'] == $u->username){
          $data['username_err'] = 'Username already exists';
        }
        if($data['email'] == $u->email){
          $data['email_err'] = 'Email has already been used';
        }
      }

      //Validate email
      if(empty($data['email']))
      {
        $data['email_err'] = 'Please enter email';
      }

      //Validate Userame
      if(empty($data['username']))
      {
        $data['username_err'] = 'Please enter username';
      }elseif(strlen($data['username']) < USER_MINUSERNAMELEN)
      {
        $data['username_err'] = 'Username must be at least '.USER_MINUSERNAMELEN.' characters.';
      }elseif(strlen($data['username']) > USER_MAXUSERNAMELEN)
      {
        $data['username_err'] = 'Username must be at most '.USER_MAXUSERNAMELEN.' characters';
      }


      if($this->userModel->doesUserExist($data['email'], $data['username'])){
        $data['email_err'] = 'Email is already taken';
      }

      //Validate Password
      if(empty($data['password']))
      {
        $data['password_err'] = 'Please enter password';
      }elseif(strlen($data['password']) < USER_MINPASSLEN)
      {
        $data['password_err'] = 'Password must be at least '.USER_MINPASSLEN.' characters';
      }

      //Validate Confirm password
      if(empty($data['confirm_password']))
      {
        $data['confirm_password_err'] = 'Please confirm password';
      }elseif($data['password'] != $data['confirm_password'])
      {
        $data['confirm_password_err'] = 'Passwords do not match';
      }

      //Check errors (TODO: There must be a better way to do this)
      if(empty($data['name_err']) && empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
      {
        //Everything is valid

        //Encrypt password
        $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

        //Register users
        if($this->userModel->register($data))
        {
          flashRedirect('/users/login','register_success','You have successfully registered!');
        }else{
          //Failure
        }

      }else {
        $this->view('users/register',$data);
      }
    }else{
      //GET request
      //Init data
      $data=[
        'username' => '',
        'email' => '',
        'name' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      //Load view
      $this->view('users/register', $data);
    }
  }

  public function login()
  {
    //Check for request type

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      //Sanitize input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data=[
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => ''
      ];



      //Validate email
      if(empty($data['email']))
      {
        $data['email_err'] = 'Please enter email';
      }

      //Validate Password
      if(empty($data['password']))
      {
        $data['password_err'] = 'Please enter password';
      }

      //Validate Login
      //Does email exist
      if($this->userModel->doesUserExist($data['email']))
      {
        //Try to login with password
        $loggedInUser = $this->userModel->login($data['email'],$data['password']);

        //If login successful
        if($loggedInUser)
        {
          //Create session
          createUserSession($loggedInUser);
        }else{
          $data['password_err'] = 'Password incorrect';
          $this->view('users/login',$data);
        }
      }else {
        $data['email_err'] = 'No user found';
      }

      //Check for errors (TODO)
      if(empty($data['email_err']) && empty($data['password_err']))
      {
        echo 'Success';
      }else{
        $this->view('users/login',$data);
      }

    }else if($_SERVER['REQUEST_METHOD'] == 'GET') {
      if(isLoggedIn())
      {
        redirect('');
      }

      //Init data
      $data=[
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => ''
      ];

      //Load view
      $this->view('users/login', $data);
    }
  }

  //View a user's profile
  public function profile($id = NULL)
  {
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
      //Not viewing another user's profile
      if(is_null($id))
      {
        //Make sure a user is logged in
        loginOrRedirect();


        $data = ['user' => $this->userModel->findUserById(getUser()['id']), 'isLoggedInProfile' => True, 'decks' => $this->deckModel->findDecksByUserId(getUser()['id'])];

        //If the user wasn't found, force a re-login
        if(empty($data['user']))
        {
          flashRedirect('/users/login','login_request','Logged in user could not be found. Please log in and try again.', 'alert alert-danger');
        }

        //User found, display profile
        $this->view('users/profile',$data);
      }
    } else {
      //Bad request
      flashRedirect('400');
    }
  }

  public function test()
  {
    consoleLog($this->userModel->findUserById(10000));
  }

  public function importDeck()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      //Make sure user is logged in
      loginOrRedirect();

      header('Content-Type: application/json');

      //Sanitize input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $errors = [];

      $deck = [
                'owner' => getUser()['id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'list' => $_POST['decklist'],
                'white' => !empty($_POST['white']),
                'blue' => !empty($_POST['blue']),
                'black' => !empty($_POST['black']),
                'red' => !empty($_POST['red']),
                'green' => !empty($_POST['green'])
              ];

      //Validations
      if(strlen($deck['title']) < DECK_MINTITLELEN)
      {
        $errors['title'] = "Title must be at least ".DECK_MINTITLELEN." characters long.";
      }else if(strlen($deck['title']) > DECK_MAXTITLELEN)
      {
        $errors['title'] = "Title must be below ".DECK_MAXTITLELEN." characters long.";
      }

      if(strlen($deck['description']) > DECK_MAXDESCRIPTIONLEN)
      {
        $errors['description'] = "Description must be below ".DECK_MAXDESCRIPTIONLEN." characters long.";
      }

      $response = [];

      if(empty($errors))
      {
        if(!$this->deckModel->importDeck($deck))
        {
          $errors['db'] = "Query unsuccessful";
          $response['errors'] = $errors;
        }else
        {
          $response['deck'] = $deck;
        }
        echo json_encode($response);
      }else{
        $response['errors'] = $errors;
        echo json_encode($response);
      }
    }
  }

  //Create session variables to login user
  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('');
  }

  //Remove session variables to logout user
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    redirect('users/login');
  }
}
 ?>
