
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
				<h3 style="text-align:center;margin-bottom:2em;">N413 Advanced Login 4 Form</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  -->
          <div class="row">
          	<div class="col-xs-2"></div> <!-- spacer column /col-xs-2 -->
            <div class="col-xs-8" style="text-align:left;">
            
            <form id="login_form" name="login_form" class="form-horizontal" method="" action="" >
                <div class="row">
        	  		<div class="col-xs-12">  
                		<div class="row" style="padding:2em;">
                        
                  			<div class="form-group">
                      			<label for="username" class="col-xs-3 control-label" >User Name</label>
                    			<div class="col-xs-3">
                      				<input type="text" id="username" name="username"  class="form-control" placeholder="User Name">
                    			</div> <!--  /.col-xs-3  -->
                  			</div> <!--  /.form-group  -->
                        
                		 	<div class="form-group"> 
                      			<label for="password" class="col-xs-3 control-label">Password </label>
                     			<div class="col-xs-3">  
                      				<input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    			</div> <!--  /.col-xs-3  -->
                  			</div> <!--  /.form-group  -->

                        </div> <!-- /.row -->    
                 		<div class="row row-gap">
            	 			<div class="col-xs-9">
                      			<button type="submit" class="btn btn-primary pull-right">Log In</button>
                                <div id="login_error" style="display:none;color:#990000;"></div>
                                <a data-toggle="modal" href="#forgotModal">Forgot Password?</a>
                   			</div>  <!-- /.col-xs-9 (BUTTON) -->
               			</div> <!-- /.row row-gap  -->
                            
       		  		</div> <!-- /col-xs-12 -->
     	    	</div> <!-- /.row -->
            </form>
            
			 </div> <!-- spacer column /col-xs-8 -->
          </div> <!-- /.row  -->
    	</div>  <!-- /.container-fluid -->
        
        <script type="text/javascript">
			// Attach a submit handler to the form
			$( "#login_form" ).submit(function( event ) {
				event.preventDefault();
				$.post("php/login.php",
						{username:$("#username").val(), password:$("#password").val()},
						function(data){
							
							//reset the error message
							$("#login_error").html("");
							$("#login_error").css("display","none");
							
							if(data.status == "success"){
								window.location = "content.php";
							}else{
								if(data.login_error != null){
									$("#login_error").html(data.login_error);
									$("#login_error").css("display","block");
								}
							}
						},
						"json"
				);
			});
		</script>
        
       <div class="modal fade" id="forgotModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">N413 Advanced Login 4 Reset Password</h4>
              </div>
              <div class="modal-body">
                <form id="reset_form" name="reset_form" class="form-horizontal" method="" action="" >
                <div class="row">
        	  		<div class="col-xs-12">  
                		<div class="row" style="padding:2em;">
                       
                            <div class="form-group"> 
                      			<label for="email" class="col-xs-3 control-label">Enter your E-mail:</label>
                     			<div class="col-xs-8">  
                      				<input type="text" id="email" name="email" class="form-control" placeholder="E-mail address">
                                    <div id="email_error" style="display:none;color:#990000;"></div>
                    			</div> <!--  /.col-xs-8  -->
                  			</div> <!--  /.form-group  -->
                            
                        </div> <!-- /.row -->    
                 		<div class="row row-gap">
            	 			<div class="col-xs-9">
                      			<button type="submit" class="btn btn-primary pull-right">Reset Password</button>
                                <div id="user_message" style="display:none;color:#990000;"></div>
                   			</div>  <!-- /.col-xs-9 (BUTTON) -->
               			</div> <!-- /.row row-gap  -->
                            
       		  		</div> <!-- /col-xs-12 -->
     	    	</div> <!-- /.row -->  
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
    	</div><!-- /.modal --> 
        
         <script type="text/javascript">
			// Attach a submit handler to the form
			$( "#reset_form" ).submit(function( event ) {
				event.preventDefault();
				$.post("php/reset.php",
						{email:$("#email").val()},
						function(data){
							
							//reset the error messages
							$("#user_message").html("");
							$("#user_message").css("display","none");
							$("#email_error").html("");
							$("#email_error").css("display","none");
							
							if(data.status == "success"){
								if(data.user_message != null){
									$("#user_message").html(data.user_message);
									$("#user_message").css("display","block");
								}
							}else{
								if(data.email_error != null){
									$("#email_error").html(data.email_error);
									$("#email_error").css("display","block");
								}
							}
						},
						"json"
				);
			});
		</script>
        
    </body>
</html>