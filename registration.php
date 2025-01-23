<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sign in</title>
    <link rel="stylesheet" href="css/loginCss.css">
</head>

<body>
    <div class="center">
        <h1>Sign in</h1>
        <form action="php/register.php" method="post">
            <div class="txt_field">
                <input type="text" name="usernameField" required>
                <span></span>
                <label>Username</label>
            </div>
            <?php
            if (isset($_SESSION["isUsernameUnavailable"])) {
                if ($_SESSION["isUsernameUnavailable"] == true) {
                    echo "
                    <div class='username_taken_error'>
                        <label> Username already exists </label>
                    </div>
                    ";
                    $_SESSION["isUsernameUnavailable"] == false;
                } else {
                }
            } else {
            }
            ?>
            <div class="txt_field">
                <input type="text" name="emailField" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="passwordField" required>
                <span></span>
                <label> Password </label>
            </div>
            <input type="submit" value="Sign in">
            <div class="signup_link">
                Already a member? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>

</html>