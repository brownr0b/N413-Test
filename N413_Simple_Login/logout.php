<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Open+Sans:400" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Logout</title>
</head>

<body>
    <div id="container">
        <div id="nav">
            <a id="register" href="register.php"><div>Register</div></a>
            <a id="login" href="login.php"><div>Login</div></a>
        </div>
        <div id="loggedout">
            <h1 class="notify">You have been logged out.</h1>
            <a id="home" href="login.php"><div>Login</div></a>
        </div>
    </div>
</body>
</html>