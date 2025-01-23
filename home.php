<?php
session_start();
if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['username']))
        $_SESSION['username'] = $_COOKIE['username'];
    else {
        header("location:login.php");
    }
}
$stack = array();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veloxify - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet" type="text/css" />

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const contacts = document.querySelectorAll('.contact');
        contacts.forEach((contact, index) => {
            setTimeout(() => {
                contact.classList.add('visible');
            }, index * 200); // 200ms delay between each contact
        });

        contacts.forEach(contact => {
            contact.addEventListener('click', () => {
                //alert(`You clicked on ${contact.textContent}`);
            });
        });
    });

    function validateForm(event) {
        const input = document.getElementById('addUserText');

        if (!input.value) {
            event.preventDefault();
        }
    }
    </script>
</head>

<body>
    <div class="center">

        <!-- <a href="php/logout.php">log out</a> -->
        <header>
            <h1>Veloxify</h1>
            <?php
            $name = $_SESSION['username'];
            echo "<h3>Welcome! $name</h3>";
            ?>
            <a href="php/logout.php">
                <button class="logout-button">Logout</button>
            </a>
        </header>
        <?php //echo '<p> benvenuto ' . $_SESSION['username'] . '</p>'; ?>
        <div class="container">
            <div class="add-friend">
                <form id="addUserForm" method="post" action="php/addUser.php">
                    <input id="addUserText" name="addUserText" type="text" placeholder="Username" minlength="1">
                    <button type="submit">Add</button>
                    <?php
                    if (isset($_SESSION['isUserNotFound'])) {
                        if ($_SESSION['isUserNotFound'] == true) {
                            echo "
                <div class='username_not_found'>
                    <label> Username not found </label>
                </div>";
                            $_SESSION['isUserNotFound'] == false;
                        } else {
                            echo "
                <div style='display: none'>
                    <label> Username not found </label>
                </div>";
                        }
                    }
                    ?>
                </form>
                <script>
                document.getElementById('addUserForm').addEventListener('submit', validateForm);
                </script>
            </div>
            <div class="contacts">
                <?php
                require ("php/connectDB.php");
                $connection = connectDb();
                if ($connection != false) {
                    try {
                        $sql = "SELECT DISTINCT * FROM chat INNER JOIN user ON chat.sentBy = user.username;";
                        $chats = $connection->query($sql);

                        $fetchedChats = $chats->fetchAll(PDO::FETCH_ASSOC);

                        echo "<form action = 'loadChat.php' method = 'post'>";
                        foreach ($fetchedChats as $chat) {
                            $sentBy = $chat['sentBy'];
                            $sentTo = $chat['sentTo'];
                            //var_dump($sentBy);
                            //var_dump($sentTo);
                            //create a list of contacts
                            if ($sentBy == $_SESSION['username']) {
                                if (!in_array($sentTo, $stack)) {
                                    echo "<button class='contact' name = '$sentTo' value = '$sentTo'>$sentTo</button><br/>";
                                    array_push($stack, $sentTo);
                                }

                            } elseif ($sentTo == $_SESSION['username']) {
                                if (!in_array($sentBy, $stack)) {
                                    echo "<button class='contact' name = '$sentBy' value = '$sentBy'>$sentBy</button><br/>";
                                    array_push($stack, $sentBy);
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo "</form>";

                } else {
                    die;
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>