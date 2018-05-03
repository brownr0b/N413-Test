<?php
include("n413connect.php");
session_start();
$_SESSION["user_id"] = 0;
$_SESSION["username"] = "";

$username_error = '';
$password_error = '';
$account_error = '';
$email_error = '';
$problems = false;

$username = "";
if(isset($_REQUEST["username"])){
	$username = html_entity_decode($_REQUEST["username"]);
    $username = trim($username);
    if (strlen($username) < 1){
        $problems = true;
        $username_error = 'You must enter a username.';
    }
    if(preg_match('/=/', $username)){
        $problems = true;
        $username_error = '"=" is not allowed for usernames.';
    }else{  //  if(preg_match('/=/', $username))
        $username = stripslashes($username);
        $username = strip_tags($username);
        $username = mysqli_real_escape_string( $link, $username );
    }
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
}

$email = "";
if(isset($_REQUEST["email"])){
    $email = html_entity_decode($_REQUEST["email"]);
    $email = trim($email);
    if (strlen($email) < 1){
        $problems = true;
        $email_error = 'You must enter your email address.';
    }
    if( ! preg_match('/@/', $email)){
        $problems = true;
        $email_error = 'You must enter a valid email address.';
    }else{
        $email = stripslashes($email);
        $email = strip_tags($email);
        $email = mysqli_real_escape_string( $link, $email );
    }
}

if( ! $problems ){
    //check for existing username
    $sql = "SELECT id FROM user_weather WHERE username = '".$username."'";
    $username_result = mysqli_query($link, $sql);

    if(mysqli_num_rows($username_result) == 0){
        //check for existing email
        $sql = "SELECT id FROM user_weather WHERE email = '".$email."'";
        $email_result = mysqli_query($link, $sql);

        if(mysqli_num_rows($email_result) == 0){
            $sql = "INSERT INTO user_weather (`id`, `username`, `password`, `email`, `home`) VALUES (NULL, '".$username."', '".$password."', '".$email."', '')";
            $result = mysqli_query($link, $sql);

            if(mysqli_affected_rows($link) == 1){
                $user_id = mysqli_insert_id($link);
                $_SESSION["user_id"] = $user_id;
                $_SESSION["username"] = $username;
            }else{
                $problems = true;
                $account_error = "Your account could not be created. Please try again later.";
            }
        } else {
            $problems = true;
            $account_error = 'The email you have selected is already in use. ';
            $email_error = ' ';
        }
    }else{
        $problems = true;
        $account_error = 'The username you have selected is already in use. ';
        $username_error = ' ';
    }
}

$data = Array();

if ($_SESSION["user_id"] > 0){
    $data["status"] = 'success';
    echo json_encode($data);
}else{
    $data["status"] = 'failed';
    if ($username_error > ''){ $data["username_error"] = $username_error; }
    if ($password_error > ''){ $data["password_error"] = $password_error; }
    if ($email_error > ''){ $data["email_error"] = $email_error; }
    if ($account_error > ''){ $data["account_error"] = $account_error; }
    echo json_encode($data);
}

session_write_close();

?>