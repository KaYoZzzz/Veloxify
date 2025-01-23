<?php
session_start();
require ("connectDB.php");
$connection = connectDb();
if ($connection != false) {
	$usernameIn = $_POST['usernameField'];
	$pswIn = $_POST['passwordField'];

	$sql = "SELECT pwd FROM user WHERE username = :username";
	$command = $connection->prepare($sql);
	$command->bindParam(':username', $usernameIn);
	$command->execute();
	$user = $command->fetch(PDO::FETCH_ASSOC);

	if ($user) {
		echo "user found";
		if (password_verify($pswIn, $user['pwd'])) {
			//echo "correct password";
			$redirect = "../home.php";
			setcookie('username', $usernameIn, time() + 60 * 60 * 24 * 60, "/");
			$_SESSION['username'] = $usernameIn;
		} else {
			//echo "wrong password";
			$redirect = "../login.php";
			$_SESSION['invalidLogin'] = true;
		}
	} else {
		//echo "<p>User not found</p>";
		$redirect = "../login.php";
		$_SESSION['invalidLogin'] = true;
	}
	//echo "<a href='$redirect'>GO</a>";
	header("Location: $redirect");
} else {
	die("Connection failed");
}
?>