<?php
session_start();
session_unset();
session_destroy();
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/n413_roster.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <title>LogOUT</title>
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
                <li id="login" class="active"><a href="login_form.php">Login</a></li>
              </ul>
            </div><!--/.collapse navbar-collapse -->
          </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12"> <!-- column for headline -->
				<h3 style="text-align:center;margin-bottom:2em;">N413 Advanced Login 4 LogOUT</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  -->
          <div class="row">
          	<div class="col-xs-2"></div> <!-- spacer column /col-xs-2 -->
            <div class="col-xs-8" style="text-align:center;">
            	
                <h4>You are now LOGGED OUT.</h4>
	
            </div> <!-- spacer column /col-xs-8 -->
          </div> <!-- /.row  -->
    	</div>  <!-- /.container-fluid -->
        
    </body>
</html>