<?php
session_start();
$sentBy = $_SESSION["username"];
$sentTo = $_SESSION["person"];
$message = $_POST["message"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        require "connectDB.php";
        $connection = connectDb();

        // Utilizzare una query preparata per evitare l'iniezione SQL
        $command = $connection->prepare("INSERT INTO chat (sentBy, textSent, sentTo) VALUES (:sentBy, :message, :sentTo)");
        $command->bindParam(':sentBy', $sentBy);
        $command->bindParam(':message', $message);
        $command->bindParam(':sentTo', $sentTo);
        $command->execute();
        echo "Message sent successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "OOOPS ERROR!";
}
?>