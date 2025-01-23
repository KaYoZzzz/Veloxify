<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/loginCss.css">
    <script>
        window.onload = function () {
            document.body.classList.add('loaded');
        };
    </script>
</head>

<?php
if (isset($_SESSION['invalidLogin']) && $_SESSION['invalidLogin'] == true) {
    echo '<script type="text/javascript"> function myFunction() { alert("Errore, nome utente o password errati"); }</script>';
    echo '<body onload="myFunction()">';
} else {
    echo '<body>';
}
?>
<div class="center">
    <h1>Login</h1>
    <form name="login" action="php/verify.php" method="post">
        <div class="txt_field">
            <input type="text" name="usernameField" required>
            <span></span>
            <label>Username</label>
        </div>
        <div class="txt_field">
            <input type="password" name="passwordField" required>
            <span></span>
            <label>Password</label>
        </div>
        <input type="submit" value="Login">
        <div class="signup_link">
            Not a member? <a href="registration.php">Signup</a>
        </div>
    </form>
</div>

<?php echo '</body>' ?>

<?php
session_destroy();
session_start();
?>

</html>