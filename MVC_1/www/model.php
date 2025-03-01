<?php

require_once "db_config.php";

class User {
    private $user_id;
    private $first_name;
    private $last_name;

    public function __construct($user_id = NULL, $first_name = "", $last_name = "") {
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function get_id() {
        return $this->user_id;
    }

    public function get_firstname() {
        return $this->first_name;
    }

    public function get_lastname() {
        return $this->last_name;
    }

    public function set_firstname($new_firstname) {
        $this->first_name = $new_firstname;
    }

    public function set_lastname($new_lastname) {
        $this->last_name = $new_lastname;
    }

    public static function get_all_users($db_connection) {
        $stmt = $db_connection->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    public static function get_user_by_id($db_connection, $id) {
        $stmt = $db_connection->prepare("SELECT * FROM users WHERE user_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($db_connection) {
        $stmt = $db_connection->prepare("INSERT INTO users (first_name, last_name) VALUES (?, ?)");
        $stmt->execute([$this->first_name, $this->last_name]);
        $this->user_id = $db_connection->lastInsertId();
    }

    public function update($db_connection) {
        $stmt = $db_connection->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE user_id = ?");
        $stmt->execute([$this->first_name, $this->last_name, $this->user_id]);
    }

    public static function delete($db_connection, $id) {
        $stmt = $db_connection->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
    }
}

?>
