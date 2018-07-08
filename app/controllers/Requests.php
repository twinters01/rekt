<?php
class Requests extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->requestModel = $this->model('Request');
  }

  public function index()
  {
    redirect('404');
  }

  public function list()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      redirect('400');
    } else {
      loginOrRedirect();

      $data = [];

      //Get requests
      $data['friendRequests'] = $this->requestModel->getFriendRequests(getUser()['id']);

      $this->view('users/requestList', $data);
    }
  }

  public function acceptFriend($requestId)
  {
    loginOrRedirect();

    $request = $this->requestModel->getRequestById($requestId);

    if(!checkUser($request->receiver_id))
    {
      flashRedirect('/requests/list','feedback_flash','You do not have permission to accept this request', 'alert alert-danger');
    }

    $friendship = $this->userModel->getFriendshipStatus(getUser()['id'], $request->sender_id);

    if(!empty($friendship->friendshipId)){
      //Friendship already exists
      //Mark request as accepted
      $this->requestModel->markAccepted($requestId);

      //Redirect to request list
      flashRedirect('/requests/list', 'feedback_flash', 'You are already friends!', 'alert alert-warning');
    }else{
      if($this->requestModel->acceptFriendRequest($requestId, $request->sender_id, $request->receiver_id))
      {
        flashRedirect('/requests/list', 'feedback_flash', 'Request accepted', 'alert alert-success');
      } else {
        flashRedirect('/requests/list', 'feedback_flash', 'Something went wrong..', 'alert alert-danger');
      }
    }
  }
}
 ?>
