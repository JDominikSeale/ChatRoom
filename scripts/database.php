<?php

class database{
    public $conn;
    public function __construct(){
        $this->conn = new mysqli("localhost","root","","chatroom");
        $this->conn->set_charset("utf8");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function login($username, $password){
        $username = $this->conn->real_escape_string($username);
        $password = $this->conn->real_escape_string($password);

        $stmt = $this->conn->prepare("SELECT UserID, Username, U_Password FROM users WHERE Username = ? AND U_Password = ?");
        if ($stmt === FALSE) {
            die("Prepare failed: " . $this->conn->error);
        }
        
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $data = $result->fetch_array();
            return $data["UserID"];
        }
        if ($result->num_rows == 0) {
            return $this->createUser($username, $password);
        }
        return 0;
    }

    private function createUser($username, $password){
        $stmt = $this->conn->prepare("INSERT INTO users (Username, U_Password) VALUES (?, ?)");
        if ($stmt === FALSE) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $this->findCreatedUser($username, $password);
    }

    private function findCreatedUser($username, $password){
        $stmt = $this->conn->prepare("SELECT UserID FROM users WHERE Username = ? AND U_Password = ?");
        if ($stmt === FALSE) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $data = $result->fetch_array();
            return $data["UserID"];
        }
    }


    public function getMessages() {
        $result = $this->conn->query("
    SELECT chat.*, users.username 
    FROM chat 
    JOIN users ON chat.userID = users.userID 
    WHERE Chat_Stamp >= NOW() - INTERVAL 1 HOUR 
    ORDER BY Chat_Stamp ASC");

        if ($result === false) {
            die("Failed to retrieve messages: " . $this->conn->error);
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addMessage($userID, $msg){
        $stmt = $this->conn->prepare("INSERT INTO chat (UserID, Chat) VALUES (?, ?)");
        if ($stmt === FALSE) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $userID, $msg);
        $stmt->execute();
    }

    public function getLatestMessage(){
        $stmt = $this->conn->prepare("SELECT Chat_Stamp FROM chat ORDER BY Chat_Stamp DESC LIMIT 1");
        if ($stmt === FALSE) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
    }
}