
<?php

session_start();
session_unset();
session_destroy();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Logout Message</title>
</head>
<body>
    <section>
        <h1>You have been logged out</h1>

        <a href="index.php">Go back to homepage</a>
    </section>
</body>
</html>