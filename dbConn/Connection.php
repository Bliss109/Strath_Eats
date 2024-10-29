<?php
class Database {
<<<<<<< HEAD
    private $host = '127.0.0.1';
    private $db_name = 'strath_eats';
    private $username = 'root';
    private $password = 'Patrickmaina05$';
=======
    private $host = 'localhost';
    private $db_name = 'strath_eats';
    private $username = 'root';
    private $password = '';
>>>>>>> master
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $exception) {
            echo 'Connection error: ' . $exception->getMessage();
        }
        return $this->conn;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> master
