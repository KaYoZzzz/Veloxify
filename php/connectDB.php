<?php
function connectDb()
{
    $host = "localhost";
    $databaseName = "chatdb";
    $username = "application";
    $password = "egmqIJcnbh!-X)yQ";
    $dsn = "mysql:host=$host;dbname=$databaseName";
    $databaseConnection = null;
    try {
        $databaseConnection = new PDO($dsn, $username, $password);
        //set the PDO error mode to exception
        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo '<p> connesso </p>';
        return $databaseConnection;
    } catch (Exception $error) {
        echo '<p>Access Denied, error ' . $error->getCode() . '</p>';
        echo '<p>message : ' . $error->getMessage() . '</p>';
        die;

    }
}
?>