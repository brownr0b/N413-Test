<?php
include("php/n413connect.php");

session_start();
$_SESSION["user_id"] = 0;
$user_id = 0;
$user_message = "";

$token = "";
if(isset($_REQUEST["token"])){
	$token = html_entity_decode($_REQUEST["token"]);
	$token = trim($token);
	$token = stripslashes($token);
	$token = strip_tags($token);
	$token = mysqli_real_escape_string( $link, $token );

	$sql = "SELECT user_id, timestamp FROM password_reset_log 
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
			$user_message .='
			<div style="text-align:center;background-color:#ffffff;border:4px solid #FF0000;">
				<p>The password reset link has expired.  Your password cannot be reset using this link.</p>
			</div>';
		
		}else{  //if ($row["time_elapsed"] > 3600)
				//link is good  -- reset the password
			$user_message .='
			<p>Please enter a new password to use with your account.  It must have at least 8 characters.<br/><br/></p>
			<form id="password_form" name="password_form" class="form-horizontal" method="" action="" >
						<div class="row">
							<div class="col-xs-12">  
								<div class="row" style="padding:2em;">                  			
								
									<div class="form-group"> 
										<label for="password" class="col-xs-3 control-label">Password </label>
										<div class="col-xs-3">  
											<input type="password" id="password" name="password" class="form-control" placeholder="Password">
											<div id="password_error" style="display:none;color:#990000;"></div>
										</div> <!--  /.col-xs-3  -->
									</div> <!--  /.form-group  -->
		
								</div> <!-- /.row -->    
								<div class="row row-gap">
									<div class="col-xs-9">
										<button type="submit" class="btn btn-primary pull-right">Submit</button>
										<div id="user_message" style="display:none;color:#990000;"></div>
									</div>  <!-- /.col-xs-9 (BUTTON) -->
								</div> <!-- /.row row-gap  -->
									
							</div> <!-- /col-xs-12 -->
						</div> <!-- /.row -->
					</form>';
		}  //  -end else- if ($row["time_elapsed"] > 3600)
	}else{ // if (mysqli_num_rows() == 1)
		$user_message .='
			<div style="text-align:center;background-color:#ffffff;border:4px solid #FF0000;">
				<p>The password reset link is not valid.  Your password cannot be reset using this link.</p>
			</div>';
	} // -end else- if (mysqli_num_rows() == 1)
}else{ // if(isset($_REQUEST["token"]))
	$user_message .='
			<div style="text-align:center;background-color:#ffffff;border:4px solid #FF0000;">
				<p>The password reset token is not valid.  Your password cannot be reset using this link.</p>
			</div>';
}// -end else- if(isset($_REQUEST["token"]))
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/n413_roster.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <title>Log-In Form</title>
    </head>
    
    <body>
    	<!-- BEGIN Bootstrap Navbar -->
    	<nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header"><!-- Mobile menu code -->
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="content.php">N413 Advanced Login 4</a>
            </div> <!-- /.navbar-header -->
            <div id="navbar" class="collapse navbar-collapse">  <!-- Full-width menu code -->
              <ul class="nav navbar-nav">
                <li><a href="content.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
              	<li id="register"><a href="registration.php">Register</a></li>
              </ul>
            </div><!--/.collapse navbar-collapse -->
          </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12"> <!-- column for headline -->
				<h3 style="text-align:center;margin-bottom:2em;">N413 Advanced Login 4 Password Reset Form</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  -->
          <div class="row">
          	<div class="col-xs-2"></div> <!-- spacer column /col-xs-2 -->
            <div class="col-xs-8" style="text-align:left;">
            
            <?php
			
				echo $user_message;
				
			?>
            
			 </div> <!-- spacer column /col-xs-8 -->
          </div> <!-- /.row  -->
    	</div>  <!-- /.container-fluid -->
        
       <script type="text/javascript">
						// Attach a submit handler to the form
						$( "#password_form" ).submit(function( event ) {
							event.preventDefault();
							$.post("php/new_password.php",
									{id:<?php echo $user_id; ?>, password:$("#password").val()},
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