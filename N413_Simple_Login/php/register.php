<?php
include("n413connect.php");

session_start();
$_SESSION["user_id"] = 0;
$_SESSION["username"] = "";

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

$sql = "SELECT id FROM user
        WHERE username = '".$username."' ";
     
$result = mysqli_query($link, $sql); 

if(mysqli_num_rows($result) == 0){
    $sql = "INSERT INTO user (`id`, `username`, `password`) 
        	VALUES (NULL, '".$username."', '".$password."' )";
	$result = mysqli_query($link, $sql); 
	if(mysqli_affected_rows($link) == 1){
     	$user_id = mysqli_insert_id($link);
     	$_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
	}
}

if ($_SESSION["user_id"] > 0){
	echo '<script type="text/javascript">
				window.location = "../index.php";
		  </script>';
}else{
	echo '<script type="text/javascript">
				window.location = "../logout.php";
		  </script>';
}

session_write_close();

?>