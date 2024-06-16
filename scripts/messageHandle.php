<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <link rel="stylesheet" type="text/css" href="../styles/chat.css">
</head>
<body>
<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
include "database.php";
$db = new database();
$messages = $db->getMessages();
?>

<div class="message-container" id="messageContainer">
<?php foreach ($messages as $message): ?>
    <div class="message">
        <h2><?php echo htmlspecialchars($message["username"]); ?></h2>
        <p><?php echo htmlspecialchars($message["Chat"]); ?></p>
        <p><small><?php echo htmlspecialchars($message["Chat_Stamp"]); ?></small></p>
    </div>
<?php endforeach; ?>
</div>


<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["message"] == "") {
        echo "Message is missing";
        exit;
    }
    $message = $_POST["message"];
    $db->addMessage($_SESSION["userID"], $message);
    header("Location: ../pages/chatroom.php");
    exit;
}
?>
</body>
</html>