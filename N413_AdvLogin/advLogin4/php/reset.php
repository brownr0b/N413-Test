<?php
include("n413connect.php");

$email_error = '';
$problems = false;
$user_id = 0;

$email = "";
if(isset($_REQUEST["email"])){
	$email = html_entity_decode($_REQUEST["email"]);
	$email = trim($email);
	//check for an empty username
	if (strlen($email) < 1){
		$problems = true;
		$email_error = 'You must enter your email address.';
	} // if (strlen($email < 1)

	//check for disallowed characters
	if( ! preg_match('/@/', $email)){
		$problems = true;
		$email_error = 'You must enter a valid email address.';
	}else{  //  if( ! preg_match('/@/', $email))
		$email = stripslashes($email);
		$email = strip_tags($email);
		$email = mysqli_real_escape_string( $link, $email );
	}  // -end else-  if( ! preg_match('/@/', $email))
	
}  //  if(isset($_REQUEST["email"]))

$sql = "SELECT id FROM adv_users 
        WHERE email = '".$email."' ";
$result = mysqli_query($link, $sql); 

if(mysqli_num_rows($result) == 1){
     $row = mysqli_fetch_array($result, MYSQLI_BOTH);
     $user_id = $row["id"];
	 $token = sha1($email.time());
	 
	 $sql = "INSERT INTO `password_reset_log` (`id`, `user_id`, `reset_token`, `timestamp`) 
	 		VALUES (NULL, '".$user_id."', '".$token."', NOW())";
	 $result = mysqli_query($link, $sql); 
	 if(mysqli_affected_rows($link) == 1){
		 $reset_link = "https://in-info-web4.informatics.iupui.edu/~brownrob/N413/N413_AdvLogin/advLogin4/reset_password.php?token=".$token;
		 $to = $_REQUEST["email"];
		 $subject = 'Password Reset Request';
		 $message = '
A password reset request has been made for your N413 AdvLogin 4 account that uses this e-mail address.  If you did not initiate this request, please notify the security team at once.
			
If you made the request, please click on the link below to reset your password.  This link will expire one hour from the time this e-mail was sent.
			
'.$reset_link.'
			';
		//be sure the /r/n (carriage return) characters are in DOUBLE QUOTES!  
		//PHP treats single quoted escaped characters differently, and things will break
		$headers = 'From: brownrob@in-info-web4.informatics.iupui.edu' . "\r\n" .
		'Reply-To:brownrob@in-info-web4.informatics.iupui.edu' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	 }else{
		 $email_error = "There was a problem with the database.  Your password cannot be reset.";
	 }
	 
}else{
	$email_error = "The e-mail address you entered was not found in the database.<br/>
	Check to be sure the e-mail address is correct and try again.";
}
	

$data = Array();

if ($user_id > 0){
	$data["status"] = 'success';
	$data["user_message"] = "A link to reset your password has been mailed to your e-mail address.<br/>The link is valid for 1 hour.";
	echo json_encode($data);
}else{
	$data["status"] = 'failed';
	if($email_error > ""){ $data["email_error"] = $email_error; }
	echo json_encode($data);
}

?>