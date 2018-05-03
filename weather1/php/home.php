<?php
include("n413connect.php");

session_start();

if(isset($_REQUEST["homeCity"])){
    $homeCity = html_entity_decode($_REQUEST["homeCity"]);
    $homeCity = trim($homeCity);
    $homeCity = stripslashes($homeCity);
    $homeCity = strip_tags($homeCity);
    $homeCity = mysqli_real_escape_string( $link, $homeCity );
}

$sql = "UPDATE user_weather set home = '". $homeCity ."' WHERE username = '" . $_SESSION["username"] . "'";

$result = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) == 1){
    echo '<script type="text/javascript">window.location = "../index.php";</script>';
}else{
    echo '<script type="text/javascript">window.location = "../index.php";</script>';
}

session_write_close();

?>