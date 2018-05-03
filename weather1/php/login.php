<?php
include("n413connect.php");

session_start();
$_SESSION["user_id"] = 0;
$_SESSION["username"] = "";

$login_error = "";

$username = "";
if(isset($_REQUEST["username"])){
    $username = html_entity_decode($_REQUEST["username"]);
    $username = trim($username);
    $username = stripslashes($username);
    $username = strip_tags($username);
    $username = mysqli_real_escape_string( $link, $username );
}

$password = "";
if(isset($_REQUEST["password"])){
    $password = html_entity_decode($_REQUEST["password"]);
    $password = trim($password);
    $password = sha1($password);
}

$sql = "SELECT id FROM user_weather WHERE username = '".$username."' AND password = '".$password."' ";
$result = mysqli_query($link, $sql);

if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    $user_id = $row["id"];
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;
}else{
    $login_error = "Incorrect username or password.";
}

$data = Array();

if ($_SESSION["user_id"] > 0){
    $data["status"] = 'success';
    echo json_encode($data);
}else{
    $data["status"] = 'failed';
    if($login_error > ""){ $data["login_error"] = $login_error; }
    echo json_encode($data);
}

//if ($_SESSION["user_id"] > 0){
//    echo '<script type="text/javascript">window.location = "../index.php";</script>';
//}else{
//    echo '<script type="text/javascript">window.location = "../index.php";</script>';
//}

session_write_close();

?>