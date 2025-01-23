<?php
session_start();
$username = $_SESSION['username'];
$conversation = $_SESSION['person'];
require "connectDB.php";
$connection = connectDb();

if ($connection != false) {
    try {
        $sql = "SELECT * FROM chat WHERE (sentBy = '$username' AND sentTo = '$conversation') OR (sentBy = '$conversation' AND sentTo = '$username') ORDER BY timestamp ASC;";
        $chats = $connection->query($sql);
        $fetchedChats = $chats->fetchAll(PDO::FETCH_ASSOC);

        foreach ($fetchedChats as $chat) {
            $sentBy = $chat['sentBy'];
            $text = $chat['textSent'];
            if (!empty($text) && !ctype_space($text)) {
                if (strcmp($sentBy, $username) == 0) {
                    echo "<div class='message sent'>$text</div>";
                } else {
                    echo "<div class='message received'>$text</div>";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error connecting to database";
    die;
}
?>