<?php
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  //Register user
  public function register($data)
  {
    $this->db->query('INSERT INTO users(username,password,name,email) VALUES(:username,:password,:name,:email)');

    //Bind data
    $this->db->bind(':username',$data['username']);
    $this->db->bind(':password',$data['password']);
    $this->db->bind(':name',$data['name']);
    $this->db->bind(':email',$data['email']);

    //Execute
    return $this->db->execute();
  }

  //Check if user exists
  public function doesUserExist($email)
  {
    //Create the query
    $this->db->query('SELECT * FROM users WHERE email = :email');

    //Bind values
    $this->db->bind(':email',$email);

    //Execute the query
    $this->db->execute();

    //Return true if a row was found
    return $this->db->rowCount() > 0;
  }

  //Find user by username or email
  public function findUserByUsernameOrEmail($username, $email)
  {
    $this->db->query('SELECT * FROM users WHERE username = :username OR email = :email');
    $this->db->bind(':username',$username);
    $this->db->bind(':email',$email);
    return $this->db->resultSet();
  }

  //Attempt a login
  public function login($email,$password)
  {
    //Create query
    $this->db->query('SELECT * FROM users WHERE email = :email');

    //Bind values
    $this->db->bind(':email',$email);

    //Execute and get result
    $row = $this->db->result();

    //Extract the password
    $hashed_password = $row->password;

    if(password_verify($password,$hashed_password))
    {
      return $row;
    }else{
      return false;
    }
  }

  //Find a user by ID
  public function findUserById($id)
  {
    //Create query
    $this->db->query('SELECT * FROM users WHERE id = :id');

    //Bind values
    $this->db->bind(':id',$id);

    return $this->db->result();
  }

  //Get a user's full friends list
  public function getFriendsListByUserId($id)
  {
    //Create query
    $this->db->query('SELECT *

                        FROM friendships f
                        INNER JOIN users friend
                        ON (f.user1_id = friend.id OR f.user2_id = friend.id)
                        AND friend.id <> :id

                        WHERE f.user1_id = :id OR f.user2_id = :id');

    //Bind values
    $this->db->bind(':id',$id);

    return $this->db->resultSet();
  }

  public function getFriendshipStatus($user1, $user2)
  {
    $this->db->query("SELECT f.id as friendshipId, r.id as requestId, r.sender_id as senderId, r.receiver_id as receiverId

                        FROM friendships f
                        RIGHT JOIN requests r
                        ON (r.sender_id = f.user1_id AND r.receiver_id = f.user2_id)
                          OR (r.receiver_id = f.user1_id AND r.sender_id = f.user2_id)

                        WHERE r.type=':type' AND r.status<>':status'
                          AND ((r.sender_id = :user1 AND r.receiver_id = :user2)
                                OR (r.sender_id = :user2 AND r.receiver_id = :user1))

                          ORDER BY friendshipId DESC");

    $this->db->bind(':user1', $user1);
    $this->db->bind(':user2', $user2);
    $this->db->bind(':type', REQUEST_TYPE_FRIEND);
    $this->db->bind(':status', REQUEST_STATUS_APPROVED);

    return $this->db->result();
  }
}
 ?>
