<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Veloxify - Chat</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/chat.css" rel="stylesheet" type="text/css">
    <script>
        let initialLoad = true;
        let userScrolled = false;

        function scrollToBottom() {
            const messagesContainer = document.querySelector('.messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function isNearBottom() {
            const messagesContainer = document.querySelector('.messages');
            const threshold = 100;
            return messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight -
                threshold;
        }

        function sendMessage() {
            var message = document.getElementById("messageField").value.trimEnd();
            if (message.length != 0) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "php/sendMessage.php");
                xhr.onload = function () {
                    document.getElementById("messageField").value = '';
                    userScrolled = false;
                    fetchMessages(scrollToBottom);
                }
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("message=" + encodeURIComponent(message));
            }
        }

        function fetchMessages(callback) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "php/loadMessages.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.querySelector('.messages').innerHTML = xhr.responseText;

                    // Scorre in fondo al primo caricamento o se l'utente non ha scrollato manualmente ed è vicino all'ultimo messaggio
                    if (initialLoad || (!userScrolled && isNearBottom())) {
                        callback();
                    }
                    initialLoad = false;
                }
            }
            xhr.send();
        }

        // Polling per aggiornare i messaggi ogni secondo
        setInterval(function () {
            fetchMessages(() => {
                if (!userScrolled && isNearBottom()) {
                    scrollToBottom();
                }
            });
        }, 1000);

        // Esegue lo scroll in fondo solo alla prima apertura della chat
        document.addEventListener('DOMContentLoaded', function () {
            fetchMessages(scrollToBottom);
        });

        // Rileva se l'utente ha scrollato manualmente
        document.querySelector('.messages').addEventListener('scroll', function () {
            userScrolled = !isNearBottom();
        });
    </script>

</head>

<body>
    <header>
        <h1>Veloxify Chat</h1>
        <a href="home.php">
            <button class="home-button">Home</button>
        </a>
        <a href="php/logout.php">
            <button class="logout-button">Logout</button>
        </a>
    </header>
    <div class="chat-container">
        <div class="messages">
            <?php
            $myPost = array_values($_POST);
            $conversation = $myPost[0];
            $username = $_SESSION['username'];
            $_SESSION['person'] = $conversation;
            ?>
        </div>
        <div class="input-container">
            <textarea id="messageField" placeholder="Type a message..." rows="1"></textarea>
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    <script>
        const textarea = document.querySelector('.input-container textarea');
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>

</html>