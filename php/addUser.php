<?php
session_start();
require ("connectDB.php");
if (isset($_POST['addUserText'])) {
    $userToAdd = htmlspecialchars($_POST['addUserText']);
    if ($userToAdd != $_SESSION['username']) {
        $connection = connectDb();

        $command = "SELECT COUNT(*) FROM user WHERE username = '$userToAdd'";
        $result = $connection->query($command);

        if ($result) {
            $array = $result->fetch(PDO::FETCH_ASSOC);
            $value = $array['COUNT(*)'];
            if ($value == 0) {
                $_SESSION['isUserNotFound'] = true;
                header('Location: ../home.php');
            } else {
                $_SESSION['isUserNotFound'] = false;
                echo 'User found!';
                $command = "
                CREATE TABLE IF NOT EXISTS chat (
                    sentBy varchar(30) NOT NULL,
                    textSent TEXT NOT NULL,
                    sentTo varchar(30) NOT NULL,
                    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (sentBy) REFERENCES user(username),
                    FOREIGN KEY (sentTo) REFERENCES user(username)
                );";
                $result = $connection->exec($command);

                $user = $_SESSION['username'];
                $command = "SELECT COUNT(*) FROM chat WHERE (sentBy = '$user' AND sentTo = '$userToAdd') OR (sentBy = '$userToAdd' AND sentTo = '$user')";
                $result = $connection->query($command);
                $array = $result->fetch(PDO::FETCH_ASSOC);
                $value = $array['COUNT(*)'];

                if ($value > 0) {
                    $_SESSION['isUserAlreadyInContacts'] = true;
                    header('Location: ../home.php');
                } else {
                    $command = "INSERT INTO chat (sentBy, textSent, sentTo) VALUES ('$user', ' ', '$userToAdd');";
                    $result = $connection->exec($command);
                    header("Location: ../home.php");
                }
            }
        }
    } else {
        echo 'THIS IS YOU<br/>';
        echo "<a href='../home.php'> GO AWAY! </a>";
    }
}
?>