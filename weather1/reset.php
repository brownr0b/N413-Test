<?php
include("php/n413connect.php");

$user_id = 0;
$user_message = "";

$token = "";
if(isset($_REQUEST["token"])){
    $token = html_entity_decode($_REQUEST["token"]);
    $token = trim($token);
    $token = stripslashes($token);
    $token = strip_tags($token);
    $token = mysqli_real_escape_string( $link, $token );

    $sql = "SELECT user_id, timestamp FROM weather_reset_log 
			WHERE reset_token = '".$token."' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        $user_id = $row["user_id"];
        $link_time = $row["timestamp"];

        $sql = "SELECT TIMESTAMPDIFF(SECOND, '".$link_time."', NOW()) as time_elapsed";
        $result = mysqli_query($link, $sql);

        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        if ($row["time_elapsed"] > 3600){  //1 hour
            //link has expired
            $user_message .='The password reset link has expired.  Your password cannot be reset using this link.';
        }else{
            //link is good  -- reset the password
            $user_message .='
			<p>Please enter a new password to use with your account.  It must have at least 8 characters.<br/><br/></p>
			<form id="new_password_form" name="new_password_form" class="form-horizontal" method="" action="" >
				<input type="password" id="passwordNew" name="password" class="form-control" placeholder="Password">
				<div id="password_error" style="display:none;text-align: center;"></div>
				<button type="submit" name="reset" id="resetbtn">Submit</button>
				<div id="user_message" style="display:none;text-align: center;"></div>
			</form>';
        }
    }else{
        $user_message .='>The password reset link is not valid.  Your password cannot be reset using this link.';
    } // -end else- if (mysqli_num_rows() == 1)
}else{ // if(isset($_REQUEST["token"]))
    $user_message .='The password reset token is not valid.  Your password cannot be reset using this link.';
}// -end else- if(isset($_REQUEST["token"]))
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
</head>

<body>

<div id="container">
    <nav>
        <div id="nav-left">
            <a href="index.php"><i class="fas fa-home"></i></a>
        </div>
    </nav>
    <div id="content">
        <?php echo $user_message; ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/fontawesome-all.js"></script>
<script type="text/javascript">
    // Attach a submit handler to the form
    $( "#new_password_form" ).submit(function( event ) {
        event.preventDefault();
        $.post("php/new_password.php",
            {id:<?php echo $user_id; ?>, password:$("#passwordNew").val()},
            function(data){
                //reset any previous error messages
                $("#user_message").html("");
                $("#user_message").css("display","none");
                $("#password_error").html("");
                $("#password_error").css("display","none");

                if(data.status == "success"){
                    if(data.user_message != null){
                        $("#user_message").html(data.user_message);
                        $("#user_message").css("display","block");
                        setTimeout(function(){window.location = 'index.php'}, 3000);
                    }
                }else{
                    if(data.password_error != null){
                        $("#password_error").html(data.password_error);
                        $("#password_error").css("display","block");
                    }
                }
            },
            "json"
        );
    });
</script>

</body>
</html>