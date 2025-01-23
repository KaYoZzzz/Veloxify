<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veloxify - Instant Messaging</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #F0EDDE;
            color: #021E36;
            /*Primary Font: 'Open Sans', Fallback Font: sans-serif*/
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            opacity: 0;
            transition: opacity 1s ease-in;
        }

        body.loaded {
            opacity: 1;
        }

        header {
            background-color: #021E36;
            color: #F0EDDE;
            padding: 20px;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        .button {
            background-color: #6892AA;
            border: none;
            color: #F0EDDE;
            padding: 15px 32px;
            text-align: center;
            /*Primary Font: 'Open Sans', Fallback Font: sans-serif*/
            font-family: 'Open Sans', sans-serif;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button:hover {
            background-color: #021E36;
            transform: scale(1.05);
        }
    </style>
    <script>
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
    </script>
</head>

<body>
    <header>
        <h1>Welcome to Veloxify</h1>
        <p>Your instant messaging solution</p>
    </header>
    <div class="container">
        <h2>Connect with friends and family instantly</h2>
        <p>Veloxify offers a fast, secure, and reliable way to stay in touch with your loved ones.</p>
        <a href="login.php">
            <button class="button">Get Started</button>
        </a>
    </div>
</body>

</html>