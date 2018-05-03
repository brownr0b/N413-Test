<?php
include("n413connect.php");

session_start();
$_SESSION["user_id"] = 0;

$username_error = '';
$password_error = '';
$account_error = '';
$email_error = '';
$problems = false;

$username = "";
if(isset($_REQUEST["username"])){
	$username = html_entity_decode($_REQUEST["username"]);
	$username = trim($username);
	//check for an empty username
	if (strlen($username) < 1){
		$problems = true;
		$username_error = 'You must enter a user name.';
	} // if (strlen($username < 1)

	//check for disallowed characters
	if(preg_match('/=/', $username)){
		$problems = true;
		$username_error = 'The "=" (equal sign) character is not allowed for user names.';
	}else{  //  if(preg_match('/=/', $username))
		$username = stripslashes($username);
		$username = strip_tags($username);
		$username = mysqli_real_escape_string( $link, $username );
	}  // -end else-  if(preg_match('/=/', $username))
	
}  //  if(isset($_REQUEST["username"]))

$password = "";
if(isset($_REQUEST["password"])){
	$password = html_entity_decode($_REQUEST["password"]);
	$password = trim($password);
	//check for password length
	if(strlen($password) < 8){
		$problems = true;
		$password_error = 'Passwords must contain at least 8 characters';
	}else{  //  if(strlen($password) < 8)
		$password = sha1($password);
	}  // -end else- if(strlen($password) < 8)
	
}  //  if(isset($_REQUEST["password"]))

$email = "";
if(isset($_REQUEST["email"])){
	$email = html_entity_decode($_REQUEST["email"]);
	$email = trim($email);
	//check for an empty email
	if (strlen($email) < 1){
		$problems = true;
		$email_error = 'You must enter your email address.';
	} // if (strlen($email < 1)

	//check for email @ character
	if( ! preg_match('/@/', $email)){
		$problems = true;
		$email_error = 'You must enter a valid email address.';
	}else{  //  if( ! preg_match('/@/', $email))
		$email = stripslashes($email);
		$email = strip_tags($email);
		$email = mysqli_real_escape_string( $link, $email );
	}  // -end else-  if( ! preg_match('/@/', $email))
	
}  //  if(isset($_REQUEST["email"]))

if( ! $problems ){
	//check for existing user name
	$sql = "SELECT id FROM adv_users 
			WHERE username = '".$username."'";
	$username_result = mysqli_query($link, $sql); 
	
	if(mysqli_num_rows($username_result) == 0){ //this is a unique user name
		//check for existing email
		$sql = "SELECT email FROM adv_users 
				WHERE email = '".$email."'";
		$email_result = mysqli_query($link, $sql); 
		
		if(mysqli_num_rows($email_result) == 0){ //this is a unique email
			$sql = "INSERT INTO adv_users (`id`, `username`, `password`, `email`) 
					VALUES (NULL, '".$username."', '".$password."', '".$email."' )";
			$result = mysqli_query($link, $sql); 
			if(mysqli_affected_rows($link) == 1){
				$user_id = mysqli_insert_id($link);
				$_SESSION["user_id"] = $user_id;
			}else{ // if(mysqli_affected_rows($link) == 1
				$account_error = 'There was a problem creating your account.  Please try again later.';
			}  // -end else- if(mysqli_affected_rows($link) == 1
		} else {// if(mysqli_num_rows($result) == 0) --email check
			$problems = true;
		} // -end else- if(mysqli_num_rows($result) == 0)  --email check
	}else{  // if(mysqli_num_rows($result) == 0) --user-name check
		$problems = true;
	}  // -end else- if(mysqli_num_rows($result) == 0) --user-name check
	
	if($problems){ $account_error = 'The user name you have selected is already in use.  Please choose a different user name. '; }
	
} // if ( ! $problems )

$data = Array();

if ($_SESSION["user_id"] > 0){
	$data["status"] = 'success';
	echo json_encode($data);
}else{ // if ($_SESSION["user_id"] > 0)
	$data["status"] = 'failed';
	if ($username_error > ''){ $data["username_error"] = $username_error; }
	if ($password_error > ''){ $data["password_error"] = $password_error; }
	if ($email_error > ''){ $data["email_error"] = $email_error; }
	if ($account_error > ''){ $data["account_error"] = $account_error; }
	echo json_encode($data);
} // -end else- if ($_SESSION["user_id"] > 0)

session_write_close();

?>