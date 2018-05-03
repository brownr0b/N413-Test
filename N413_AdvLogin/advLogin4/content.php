<?php
session_start();
if(! isset($_SESSION["user_id"])){ 
	$_SESSION["user_id"] = 0;
}

?>

<DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/n413_roster.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <title>N413 Login Content</title>
        
        <script type="text/javascript">
		<?php 
			if($_SESSION["user_id"] > 0){
				echo '
				var log_in = true;';
			}else{
				echo '
				var log_in = false;';
			}
		?>	
		
		function check_login(){
			if(log_in){
				$("#login").html('<a href="logout.php">Logout</a>');
				$("#register").html('');
			}else{
				window.location = "login_form.php";
			}
		}
		
		$(document).ready(function() {	
    		check_login();
		});
		
		</script>
        
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
              <a class="navbar-brand" href="#">N413 Advanced Login 4</a>
            </div> <!-- /.navbar-header -->
            <div id="navbar" class="collapse navbar-collapse">  <!-- Full-width menu code -->
              <ul class="nav navbar-nav">
                <li class="active"><a href="content.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
              	<li id="register"><a href="registration.php">Register</a></li>
                <li id="login"><a href="login_form.php">Login</a></li>
              </ul>
            </div><!--/.collapse navbar-collapse -->
          </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12"> <!-- column for headline -->
				<h3 style="text-align:center;margin-bottom:2em;">N413 Advanced Login 4</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  -->
          <div class="row">
          	<div class="col-xs-2"></div> <!-- spacer column /col-xs-2 -->
            <div class="col-xs-8">
            	<p>Login systems are essential for any kind of project that provides or accepts individual user data.  Login systems depend on at least two, and usually three items:</p>
                <ul>
                	<li><b>A "session".</b>  A session in PHP is a set of programming variables that are stored to a disk file on the server, and accessed with a key stored in a "cookie" in the user's browser.  The PHP session variable is a PHP associative array, accessed with the variable name $_SESSION.  Since the session variable is persistent between page loads, data such as preferences, authentication, etc., can be available as long as a user remains on a site.</li>
					<li><b>An identifier.</b>  A browser cookie or IP address can be used as an identifier, but a user name is the general way users are identified.  User names are typically stored in a database table, along with an ID number.  The user ID number will be placed in a session variable to create a "log-in", and the user ID becomes a key for user information in the database.</li>
					<li><b>Authorization.</b>  In most situations, it is important to verify the user's identity with a password.  The password is stored along with the user name in the database, and checked against the user-provided password.  The user ID is only stored in a session variable when the correct password is provided.  To protect the password, encryption is used to prevent the password from being human-readable.</li>
				</ul>
                <h4>Sessions</h4>
				<p>Creating a session is simple.  Just use the PHP method session_start().  This will either initialize a new session or resume a session using the browser cookie.  This creates the $_SESSION variable, and in the case of resuming a session, it loads any saved session data into the variable.  The session variable is a "superglobal", and can be referenced from anywhere inside a PHP script.
Session data is written to a server disk file when the PHP script finishes, but you can call session_write_close() to force the session data to be written to disk.  This also insures that another script can access the session, as only one script may use the session at a time.</p>
				<p>A newly created session has very little data other than a session ID.  You must add any data you want the session to have.  To add data to the session variable, use this form:</p>
				<pre>$_SESSION["my_data"] = "test data";</pre>
				<p>You can use any text string as the key, and the data can be any data type  -- variables, strings, numbers, arrays, etc.</p>  
				<p>Sessions do not expire, so generally a time stamp is added so the session can be tested for how old it is.  When the session is opened, the elapsed time can be checked.  If the session is within its time allotment, the session can be updated with a fresh timestamp. Sessions beyond the desired age can be destroyed with session_destroy().  The session variable can be unset with session_unset().</p>


            </div> <!-- spacer column /col-xs-8 -->
          </div> <!-- /.row  -->
    	</div>  <!-- /.container-fluid -->
        
    </body>
</html>

<?php
session_write_close();
?>