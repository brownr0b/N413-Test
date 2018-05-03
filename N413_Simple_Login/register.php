<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Open+Sans:400" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Register</title>
</head>
<body>
    <div id="container">
        <div id="nav">
            <a id="login" href="login.php"><div>Login</div></a>
        </div>
        <div id="registration">
            <h1 class="notify">Registration</h1>
            <form id="register_form" name="register_form" method="post" action="php/register.php">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" id="submit" value="Register">
            </form>
        </div>
    </div>
</body>
</html>