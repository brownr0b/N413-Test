<?php
include("php/n413connect.php");

if(isset($_REQUEST["first_name"])){
	$first_name = html_entity_decode($_REQUEST["first_name"]);
	$first_name = trim($first_name);
	$first_name = stripslashes($first_name);
	$first_name = strip_tags($first_name);
	$first_name = mysqli_real_escape_string( $link, $first_name );
}

if(isset($_REQUEST["last_name"])){
	$last_name = html_entity_decode($_REQUEST["last_name"]);
	$last_name = trim($last_name);
	$last_name = stripslashes($last_name);
	$last_name = strip_tags($last_name);
	$last_name = mysqli_real_escape_string( $link, $last_name );
}

if(isset($_REQUEST["email"])){
	$email = html_entity_decode($_REQUEST["email"]);
	$email = trim($email);
	$email = stripslashes($email);
	$email = strip_tags($email);
	$email = mysqli_real_escape_string( $link, $email );
}

if(isset($_REQUEST["comment"])){
    $comment = html_entity_decode($_REQUEST["comment"]);
    $comment = trim($comment);
    $comment = stripslashes($comment);
    $comment = strip_tags($comment);
    $comment = mysqli_real_escape_string( $link, $comment );
}

$sql = "INSERT INTO `contact` (`id`, `first_name`, `last_name`, `email`, `comment`)
		VALUES (NULL, '".$first_name."', '".$last_name."', '".$email."', '".$comment."')";
		
$result = mysqli_query($link, $sql);	

if (mysqli_affected_rows($link) == 1){	
	$success = true;
}else{
	$success = false;
}

//redraw the page
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/n413_contact.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <title>Contact Form</title>
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
              </button>
              <a class="navbar-brand" href="#">N413 Contact</a>
            </div> <!-- /.navbar-header -->
            <div id="navbar" class="collapse navbar-collapse">  <!-- Full-width menu code -->
              <ul class="nav navbar-nav">
                <li><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li class="active"><a href="#contact">Contact</a></li>
              </ul>
            </div><!--/.collapse navbar-collapse -->
          </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12"> <!-- column for headline -->
				<h3 style="text-align:center;margin-bottom:2em;">N413 Contact Form</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  --> 
          <div class="row">
            <div class="col-xs-12"> <!-- column for message -->
            <?php
				if($success){
					echo '
            			<p style="text-align:center;">Your contact information has been submitted successfully. Thanks!</p>';
				}else{
					echo '
						<p style="text-align:center;">A dinosaur came and ate your information. Please try again later.</p>';
				}
			?>
                <div style="margin-top:2em;text-align:center;">
                    <button type="button" class="btn btn-primary" onclick="javascript:window.location='contact.html';" >
                          Return to Contact Form
                    </button>
                </div>
			</div>  <!-- /.col-xs-12  -->
         </div>  <!-- /.row  --> 
       </div>  <!-- /.container-fluid -->
    </body>
</html>