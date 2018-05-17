<?php
class Request
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  //Open a request
  public function createRequest($data)
  {

    $this->db->query('INSERT INTO requests(sender_id,receiver_id,type,subject_id,status)
                        VALUES(:sender_id,:receiver_id,:type,:subject_id,:status)');

    $this->db->bind(':sender_id', $data['sender_id']);
    $this->db->bind(':receiver_id', $data['receiver_id']);
    $this->db->bind(':type', $data['type']);
    $this->db->bind(':subject_id', $data['subject_id']);
    $this->db->bind(':status', $data['status']);

    return $this->db->execute();
  }

  //Send a friend request
  public function sendFriendRequest($data)
  {
    return $this->createRequest([
      'sender_id' => $data['sender_id'],
      'receiver_id' => $data['receiver_id'],
      'type' => 'f', //Friend
      'status' => 'p' //Pending
    ]);
  }
}
 ?>
