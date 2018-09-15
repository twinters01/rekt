<?php
class Deck
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  ///////////////////////
  //WRITE
  ///////////////////////
  public function findDecksByUserId($userId)
  {
    $this->db->query('SELECT * FROM decks WHERE owner=:owner');

    $this->db->bind(':owner', $userId);

    return $this->db->resultSet();
  }

  ///////////////////////
  //WRITE
  ///////////////////////
  public function importDeck($deck)
  {
    $this->db->query('INSERT INTO decks(owner,title,description,list,white,blue,black,red,green)
                        VALUES(:owner,:title,:description,:list,:white,:blue,:black,:red,:green)');

    $this->db->bind(':owner', $deck['owner']);
    $this->db->bind(':title', $deck['title']);
    $this->db->bind(':description', $deck['description']);
    $this->db->bind(':list', $deck['list']);
    $this->db->bind(':white', $deck['white']);
    $this->db->bind(':blue', $deck['blue']);
    $this->db->bind(':black', $deck['black']);
    $this->db->bind(':red', $deck['red']);
    $this->db->bind(':green', $deck['green']);

    return $this->db->execute();
  }
}
 ?>
