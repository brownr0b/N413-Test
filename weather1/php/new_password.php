<?php
include("n413connect.php");

$password_error = 'trouble';
$user_message = '';
$problems = false;

$user_id = 0;
if(isset($_REQUEST["id"])){
    $user_id = intval($_REQUEST["id"]);
}else{
    $problems = true;
    $password_error = 'Password cannot be reset';
}

$password = "";
if(isset($_REQUEST["password"])){
    $password = html_entity_decode($_REQUEST["password"]);
    $password = trim($password);
    if(strlen($password) < 8){
        $problems = true;
        $password_error = 'Passwords must contain at least 8 characters';
    }else{
        $password = sha1($password);
    }

}else{
    $problems = true;
    $password_error = 'Please provide a password.';
}

if( ! $problems ){
    $sql = "UPDATE user_weather set `password` = '".$password."' WHERE id = '".$user_id."' ";
    $result = mysqli_query($link, $sql);
    $data = Array();
    $data["status"] = 'success';
    $data["user_message"] = 'Your password has been successfully reset.<br/> Redirecting...';
    echo json_encode($data);
}else{
    $password_error = 'Your password could not be reset.';
    $data = Array();
    $data["status"] = 'failed';
    if ($password_error > ''){ $data["password_error"] = $password_error; }
    echo json_encode($data);
}

?>