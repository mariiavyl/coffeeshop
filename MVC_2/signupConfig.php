<?php

require_once("database.php");

class signupConfig {
    private $id;
    private $firstName;
    private $lastName;
    private $address;
    protected $dbCnx;  

    public function __construct($id = NULL, $firstName = "", $lastName = "", $address = "") {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->dbCnx = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PWD, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAddress() {
        return $this->address;
    }

    public function insertData() {
        try {
            $stmt = $this->dbCnx->prepare("INSERT INTO users (firstName, lastName, address) VALUES (?, ?, ?)");
            $stmt->execute([$this->firstName, $this->lastName, $this->address]);
            echo "<script>alert('Data saved successfully'); document.location='allData.php';</script>";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function fetchAll() {
        try {
            $stmt = $this->dbCnx->prepare("SELECT * FROM users"); 
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function fetchOne() {
        try {
            $stmt = $this->dbCnx->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$this->id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

   public function update($id, $firstName, $lastName, $address) {
        try {
            $sql = "UPDATE users SET firstName=?, lastName=?, address=? WHERE id=?";
            $stmt = $this->dbCnx->prepare($sql);
            $stmt->execute([$firstName, $lastName, $address, $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    

    public function delete() {
        try { 
            $stmt = $this->dbCnx->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$this->id]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>
