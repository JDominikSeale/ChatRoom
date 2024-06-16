<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["username"] == "" || $_POST["password"] == "") {
        echo "Fields are missing";
        exit;
    }
    $username = $_POST["username"];
    $password = $_POST["password"];
    $db = new database();
    $userID = $db->login($username, $password);
    if ($userID > 0) {
        echo "Login successful";

        $_SESSION["username"] = $username;
        $_SESSION["userID"] = $userID;
        header("Location: ../pages/chatroom.php");
        exit;
    } else {
        echo "Login failed";
    }
}