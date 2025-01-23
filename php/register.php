<?php
session_start();
try {
    //echo ("<p> AAAAAA </p>");
    require ("connectDB.php");
    $connection = connectDb();
    //var_dump($connection);
    $command = "CREATE TABLE IF NOT EXISTS user(username varchar(30) NOT NULL PRIMARY KEY, email varchar(100) NOT NULL, pwd varchar(300) NOT NULL);";
    //var_dump($command);
    $connection->exec($command);
    $usernameField = $_POST["usernameField"];
    $emailField = $_POST["emailField"];
    $passwordField = $_POST["passwordField"];
    $hashedPassword = password_hash($passwordField, PASSWORD_DEFAULT);
    //echo ("<script>alert('W')</script>");
    //$command = 'INSERT INTO user (username, email, pwd) VALUES ("'. $_POST["usernameField"]. '","'. $_POST["emailField"]. '","'. $_POST["passwordField"]. '");';
    $command = $connection->prepare("INSERT INTO user (username, email, pwd) VALUES (:username,:email,:pwd)");
    $command->bindParam(':username', $usernameField);
    $command->bindParam(':email', $emailField);
    $command->bindParam(':pwd', $hashedPassword);
    //echo $command;
    $command->execute();
    //echo ("<script>alert ('signin eseguito');</script>");
    header("Location: ../login.php");
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getCode() . "</p>";
    if ($e->getCode() == 23000) {
        echo "<p> Username already exists </p>";
        $command = "DELETE FROM user WHERE username = '';";
        $connection->exec($command);
        $_SESSION['isUsernameUnavailable'] = true;
        header("Location: ../registration.php");
    }
}
?>