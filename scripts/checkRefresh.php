<?php
if(session_status() == PHP_SESSION_NONE){
    // session has not started
    session_start();
}
include "database.php";
$db = new database();


// Get the timestamp of the last message the user saw
$lastMessageTimestamp = $_SESSION['lastMessageTimestamp'];

// Get the latest message from the database
$latestMessage = $db->getLatestMessage();

// If there is a new message, return 'new_message'
if ($latestMessage['Chat_Stamp'] > $lastMessageTimestamp) {
    echo 'new_message';
}

// Update the timestamp of the last message the user saw
$_SESSION['lastMessageTimestamp'] = $latestMessage['Chat_Stamp'];