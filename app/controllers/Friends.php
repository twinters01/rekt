<?php
class Friends extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->requestModel = $this->model('Request');
  }

  public function list()
  {
    $data = [];

    //Redirect to login if there is no logged in user
    if(!isLoggedIn())
    {
      flashRedirect('/users/login','login_request','Please login!','alert alert-danger');
    }

    $data['friends'] = $this->userModel->getFriendsListByUserId(getUser()['id']);

    $this->view('friends/list',$data);
  }

  //TODO: extract some of these validations so they can be reused for a "quick-add" button later on
  public function add()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      //Sanitize input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      if(empty(trim($_POST['username'])))
      {
        flashRedirect('/friends/list', 'feedback_flash', 'Please enter a username to add', 'alert alert-danger');
      }

      $target = $this->userModel->findUserByUsernameOrEmail(trim($_POST['username']), '');

      if(empty($target))
      {
        //Didn't find a user with that name
        flashRedirect('/friends/list', 'feedback_flash', 'User does not exist!', 'alert alert-danger');
      }else if(checkUser($target[0]->id)){
        //Username entered is the currently logged in user
        flashRedirect('/friends/list', 'feedback_flash', '*You give yourself a high five*');
      }else{
        //User found! Already friends?
        $friendship = $this->userModel->getFriendshipStatus(getUser()['id'], $target[0]->id);

        if(empty($friendship))
        {
          //No relationship found, send request
          if($this->requestModel->sendFriendRequest(['sender_id'=>getUser()['id'],'receiver_id' => $target[0]->id]))
          {
            flashRedirect('/friends/list', 'feedback_flash', 'Request sent!', 'alert alert-success');
          } else {
            flashRedirect('/friends/list', 'feedback_flash', 'Something went wrong, please try again', 'alert alert-danger');
          }
        }else if(!empty($friendship->friendshipId)){
          //Friendship already exists
          flashRedirect('/friends/list', 'feedback_flash', 'You are already friends!', 'alert alert-warning');
        }else if(!empty($friendship->requestId)){
          //There is alredy an active request
          if(checkUser($friendship->senderId))
          {
            //User already sent a request
            flashRedirect('/friends/list', 'feedback_flash', 'You\'ve already sent a request to this user!', 'alert alert-warning');
          }else {
            //User has a pending request from the target
            flashRedirect('/friends/list', 'feedback_flash', 'Check your requests! You have a pending request from this user', 'alert alert-warning');
          }
        }

      }
    } else{
      flashRedirect('/friends/list','feedback_flash','Invalid request');
    }
  }
}
 ?>
