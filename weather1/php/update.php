<?php
include("n413connect.php");

session_start();

$username = '';
if(isset($_REQUEST["username"])){
    $username = html_entity_decode($_REQUEST["username"]);
    $username = trim($username);
    $username = stripslashes($username);
    $username = strip_tags($username);
    $username = mysqli_real_escape_string( $link, $username );
}

$password = '';
if(isset($_REQUEST["password"])){
    $password = html_entity_decode($_REQUEST["password"]);
    $password = trim($password);
    //$password = sha1($password);
}

if ($username && empty($password)){
    $sqlUser = "SELECT username FROM user_weather WHERE username = '".$username."'";
    $result = mysqli_query($link, $sqlUser);

    if(mysqli_num_rows($result) >= 1){
        echo "Username taken";
        echo '<script type="text/javascript">window.location = "../index.php";</script>';
    }else{
        $sql = "UPDATE user_weather set username = '".$username."' WHERE username = '" . $_SESSION["username"] . "'";
        $result = mysqli_query($link, $sql);
        $_SESSION["username"] = $username;
        echo '<script type="text/javascript">window.location = "../index.php";</script>';
    }
}else if ($password && empty($username)) {
        $password = sha1($password);
        $sql = "UPDATE user_weather set password = '" . $password . "' WHERE username = '" . $_SESSION["username"] . "'";
        $result = mysqli_query($link, $sql);
        echo '<script type="text/javascript">window.location = "../index.php";</script>';
}else if (empty($username) && empty($password)){
        echo '<script type="text/javascript">window.location = "../index.php";</script>';
}else{
    $sqlUser = "SELECT username FROM user_weather WHERE username = '".$username."'";
    $result = mysqli_query($link, $sqlUser);

    if(mysqli_num_rows($result) >= 1){
        echo "Username taken";
        echo '<script type="text/javascript">window.location = "../index.php";</script>';
    }else{
        $password = sha1($password);
        $sql = "UPDATE user_weather set username = '".$username."', password = '" . $password . "' WHERE username = '" . $_SESSION["username"] . "'";
        $result = mysqli_multi_query($link, $sql);
        $_SESSION["username"] = $username;

        echo '<script type="text/javascript">window.location = "../index.php";</script>';
    }
}

session_write_close();
?>