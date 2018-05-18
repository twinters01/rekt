<?php
class Request
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  ///////////////////////
  //READ
  ///////////////////////
  public function getRequestById($requestId)
  {
    $this->db->query('SELECT * FROM requests WHERE id=:requestId');

    $this->db->bind(':requestId',$requestId);

    return $this->db->result();
  }

  public function getFriendRequests($userId)
  {
    $this->db->query('SELECT u.username as sender_username, u.name as sender_name, r.id as requestId, r.status as status, r.created_date as request_date

                        FROM requests r
                        INNER JOIN users u
                        ON u.id = r.sender_id

                        WHERE r.receiver_id = :user
                        AND r.type = \'f\'
                        AND r.status <> \'a\'

                        ORDER BY r.status DESC, r.created_date DESC');

    $this->db->bind(':user', $userId);

    return $this->db->resultSet();
  }


  ///////////////////////
  //CREATE
  ///////////////////////

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
  public function createFriendRequest($data)
  {
    return $this->createRequest([
      'sender_id' => $data['sender_id'],
      'receiver_id' => $data['receiver_id'],
      'type' => 'f', //Friend
      'status' => 'p' //Pending
    ]);
  }

  ///////////////////////
  //UPDATE
  ///////////////////////

  //Accept a friend request
  public function acceptFriendRequest($requestId, $senderId, $receiverId)
  {
    $this->db->query('INSERT INTO friendships(user1_id,user2_id) VALUES(:senderId, :receiverId)');

    $this->db->bind(':senderId', $senderId);
    $this->db->bind(':receiverId',$receiverId);

    if($this->db->execute())
    {
      $this->db->query('UPDATE requests SET status = \'a\' WHERE id = :requestId');
      $this->db->bind(':requestId', $requestId);
      return $this->db->execute();
    }else{
      return False;
    }
  }
}
 ?>
