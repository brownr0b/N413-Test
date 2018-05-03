
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/n413_roster.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <title>Registration Form</title>
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
                <li id="login"><a href="login_form.php">Login</a></li>
              </ul>
            </div><!--/.collapse navbar-collapse -->
          </div><!--/.container -->
        </nav>
        <!-- END Bootstrap Navbar -->
        
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12"> <!-- column for headline -->
				<h3 style="text-align:center;margin-bottom:2em;">N413 Advanced Login 4 Registration</h3>
            </div> <!-- /col-xs-12 -->
          </div> <!-- /.row  -->
          <div class="row">
          	<div class="col-xs-2"></div> <!-- spacer column /col-xs-2 -->
            <div class="col-xs-8" style="text-align:left;">
            
            <form id="register_form" name="register_form" class="form-horizontal" method="" action="" >
                <div class="row">
        	  		<div class="col-xs-12">  
                		<div class="row" style="padding:2em;">
                        
                  			<div class="form-group">
                      			<label for="username" class="col-xs-3 control-label" >User Name</label>
                    			<div class="col-xs-3">
                      				<input type="text" id="username" name="username"  class="form-control" placeholder="User Name">
                                    <div id="username_error" style="display:none;color:#990000;"></div>
                    			</div> <!--  /.col-xs-3  -->
                  			</div> <!--  /.form-group  -->
                        
                		 	<div class="form-group"> 
                      			<label for="password" class="col-xs-3 control-label">Password </label>
                     			<div class="col-xs-3">  
                      				<input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                    <div id="password_error" style="display:none;color:#990000;"></div>
                    			</div> <!--  /.col-xs-3  -->
                  			</div> <!--  /.form-group  -->
                            
                            <div class="form-group"> 
                      			<label for="email" class="col-xs-3 control-label">E-mail</label>
                     			<div class="col-xs-3">  
                      				<input type="text" id="email" name="email" class="form-control" placeholder="E-mail address">
                                    <div id="email_error" style="display:none;color:#990000;"></div>
                    			</div> <!--  /.col-xs-3  -->
                  			</div> <!--  /.form-group  -->
                            
                        </div> <!-- /.row -->    
                 		<div class="row row-gap">
            	 			<div class="col-xs-9">
                      			<button type="submit" class="btn btn-primary pull-right">Register</button>
                                <div id="account_error" style="display:none;color:#990000;"></div>
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
			$( "#register_form" ).submit(function( event ) {
				event.preventDefault();
				$.post("php/register.php",
						{username:$("#username").val(), password:$("#password").val(), email:$("#email").val()},
						function(data){
							
							//reset any previous error messages
							$("#username_error").html("");
							$("#username_error").css("display","none");
							$("#password_error").html("");
							$("#password_error").css("display","none");
							$("#email_error").html("");
							$("#email_error").css("display","none");
							$("#account_error").html("");
							$("#account_error").css("display","none");
							
							if(data.status == "success"){
								window.location = "content.php";
							}else{
								if(data.username_error != null){
									$("#username_error").html(data.username_error);
									$("#username_error").css("display","block");
								}
								if(data.password_error != null){
									$("#password_error").html(data.password_error);
									$("#password_error").css("display","block");
								}
								if(data.email_error != null){
									$("#email_error").html(data.email_error);
									$("#email_error").css("display","block");
								}
								if(data.account_error != null){
									$("#account_error").html(data.account_error);
									$("#account_error").css("display","block");
								}
							}
						},
						"json"
				);
			});
		</script>
        
    </body>
</html>