<?php
class DB{
    private $db;
    private $lastId;
    public function __construct()
    {
        $servername = "us-cdbr-iron-east-05.cleardb.net:3306";
        $username = "b9fb0372682c82";
        $password = "f3d42555";
        $database = "heroku_99595f089932bf8";
        $this->db = mysqli_connect($servername,$username,$password,$database);
        
    }
    public function query($txt){
        $return = $this->db->query($txt);
        $this->lastId = $this->db->insert_id;
       return $return;
    }

    public function prepare($txt){
        return $this->db->prepare($txt);
    }
    public function close(){
        $this->db->close();
    }
    public function getLastInsertedId(){
        return $this->lastId;
    }
}


?>