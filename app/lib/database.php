<?php
  /*
    PDO Database class
      - Connect to Database
      - Create prepared statements
      - Bind values
      - Return rows and results
  */
  class Database
  {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
      $dsn = 'mysql:host='.$this->host.'; dbname='.$this->dbname;
      $options = array(PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ);

      //Create PDO instance
      try{
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch(PDOException $e){
        $this->error = $e->getMessage();
        echo $this->error;
      }
    }

    //Prepare a statement with query
    public function query($sql)
    {
      $this->stmt = $this->dbh->prepare($sql);
    }

    //Bind value to the statement
    public function bind($param,$value,$type=null)
    {
      //If the type is not defined, manually define it
      if(is_null($type))
      {
        switch(true)
        {
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          default:
            $type = PDO::PARAM_STR;
            break;
        }
      }
      //Bind the value
      $this->stmt->bindValue($param,$value,$type);
    }

    //Execute the prepared statements
    public function execute()
    {
      return $this->stmt->execute();
    }

    //Get result set as array of objects
    public function resultSet()
    {
      $this->execute();
      return $this->stmt->fetchAll();
    }

    //Get single result
    public function result()
    {
      $this->execute();
      return $this->stmt->fetch();
    }

    //Get row count
    public function rowCount()
    {
      return $this->stmt->rowCount();
    }
  }
 ?>
