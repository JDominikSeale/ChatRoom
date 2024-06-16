<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
</head>
<body>
    <?php
    if (!isset($_SESSION["username"])) {
        header("Location: ../index.php");
        exit;
    }
    ?>
    <h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
    <form action="../scripts/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    <?php include "../scripts/messageHandle.php"; ?>
    <form action="../scripts/messageHandle.php" method="post">
        <input type="text" name="message" id="textMessageBox">
        <button type="submit">Send</button>
    </form>
    <script>
    var textMessageBox = document.getElementById('textMessageBox');
    textMessageBox.value = sessionStorage.getItem('storedText');
    </script>
<script src="../scripts/messageRefresh.js"></script>
<script src="../scripts/messageRoom.js"></script>
</body>
</html>

