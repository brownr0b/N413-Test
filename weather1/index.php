<?php
include("php/n413connect.php");
session_start();
if(! isset($_SESSION["user_id"])){
    $_SESSION["user_id"] = 0;
    $_SESSION["username"] = "";
}

if($_SESSION["user_id"] > 0){
    $sqlOutput = "SELECT * FROM history_weather WHERE user_id = '".$_SESSION["user_id"]."' ORDER BY timestamp DESC Limit 3;";
    $resultOutput = mysqli_query($link, $sqlOutput);
    $result_array2 = Array();

    if(mysqli_num_rows($resultOutput) === 1){
        while($rowOutput = $resultOutput->fetch_assoc()) {
            $result_array2[] = $rowOutput["city"];
        }
        array_push($result_array2, "Los Angeles","New York");
        $json_array2 = json_encode($result_array2);
    }else if(mysqli_num_rows($resultOutput) === 2){
        while($rowOutput = $resultOutput->fetch_assoc()) {
            $result_array2[] = $rowOutput["city"];
        }
        array_push($result_array2, "Los Angeles");
        $json_array2 = json_encode($result_array2);
    }else if(mysqli_num_rows($resultOutput) >= 3){
        while($rowOutput = $resultOutput->fetch_assoc()) {
            $result_array2[] = $rowOutput["city"];
        }
        $json_array2 = json_encode($result_array2);
    }else{
        $result_array2 = array("Los Angeles", "New York", "Washington");
        $json_array2 = json_encode($result_array2);
    }
}else{
    $result_array2 = array("Los Angeles", "New York", "Washington");
    $json_array2 = json_encode($result_array2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brownrob Weather</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/weather-icons.min.css">
    <link rel="stylesheet" href="css/weather-icons-wind.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div id="container">
        <nav>
            <div id="nav-left">
                <a href="index.php"><i class="fas fa-home"></i></a>
                <form class="form" method="get" action="city.php">
                    <input type="text" id="place" placeholder="Search City or Zip" name="q" size="15" required>
                    <button type="submit" id="submit"><i class="far fa-search"></i></button>
                </form>
                <a id="geolocation" title="Find Me"><i class="far fa-location-arrow"></i></a>
            </div>
            <div id="nav-right">
                <a href="#" class="login" data-toggle="modal" data-target="#login">Login</a>
                <a href="#" class="register" data-toggle="modal" data-target="#register">Register</a>
            </div>
        </nav>
        <div id="content">
            <div id="home">
                <div id="homeCurrent"></div>
                <div id="homeForecast"></div>
            </div>
            <div id="cities">
                <div id="citiesContainer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="far fa-times"></i></span></button>
                    <h4 class="modal-title">Register</h4>
                </div>
                <div class="modal-body">
                    <form id="register_form" name="register_form" class="form-horizontal" method="" action="">
                        <input type="text" placeholder="Username" name="username" id="usernameRegister">
                        <div id="username_error" style="display:none;color:#FF0000;"></div>
                        <input type="text" placeholder="Email" name="email" id="emailRegister">
                        <div id="email_error" style="display:none;color:#FF0000;"></div>
                        <input type="password" placeholder="Password" name="password" id="passwordRegister">
                        <div id="password_error" style="display:none;color:#FF0000;"></div>
                        <button type="submit" name="register" id="registerbtn">Register</button>
                        <div id="account_error" style="display:none;color:#FF0000;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="login" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="far fa-times"></i></span></button>
                    <h4>Login</h4>
                </div>
                <div class="modal-body">
                    <form id="login_form" name="login_form" class="form-horizontal"  method="" action="" >
                        <input type="text" placeholder="Username" name="username" id="usernameLogin">
                        <input type="password" placeholder="Password" name="password" id="passwordLogin">
                        <button type="submit" name="login" id="loginbtn">Log in</button>
                        <div id="login_error" style="display:none;color:#FF0000;"></div>
                    </form>
                    <a data-dismiss="modal" data-toggle="modal" data-target="#reset" href="#" class="forgot">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reset" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="far fa-times"></i></span></button>
                    <h4>Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form id="reset_form" name="reset_form" class="form-horizontal"  method="" action="" >
                        <input type="text" id="emailReset" name="email" class="form-control" placeholder="Email">
                        <div id="reset_error" style="display:none;color:#FF0000;"></div>
                        <button type="submit" name="reset" id="resetbtn">Reset Password</button>
                        <div id="user_message" style="display:none;color:#FF0000;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="far fa-times"></i></span></button>
                    <h4>Profile Settings</h4>
                </div>
                <div class="modal-body">
                    <form id="update_form" name="update_form" class="form-horizontal"  method="post" action="php/update.php" >
                        <label>Change Username</label>
                        <div class="changeUsername">
                            <input type="text" placeholder="<?php echo ucfirst(strtolower($_SESSION["username"])) ?>" name="username">
                            <button type="submit" name="update" class="updatebtn">Update</button>
                        </div>
                        <label>Change Password</label>
                        <div class="changePassword">
                            <input type="password" name="password" title="password">
                            <button type="submit" name="update" class="updatebtn">Update</button>
                        </div>
                    </form>
                    <div id="history">
                        <label>Search History</label>
                        <div id="historyContainer">
                            <?php
                            echo '<table id="historyTable"><thead><th>City</th><th>Date</th><th></th></thead>';

                                $sqlHistory = "SELECT * FROM history_weather WHERE user_id = '".$_SESSION["user_id"]."' ORDER BY timestamp DESC LIMIT 10; ";
                                $result1 = mysqli_query($link, $sqlHistory);

                                if(mysqli_num_rows($result1) >= 1){
                                    while($row1 = $result1->fetch_assoc()) {
                                        echo '<tr><td><a href="city.php?q='.$row1["city"].'" title="'.$row1["city"].'">'.$row1["city"].'</a></td><td>'.$row1["timestamp"].'</td><td data-city="' .$row1["city"]. '"><i class="far fa-times"></i></td></tr>';
                                    }
                                }else{
                                    echo '<td>You haven\'t searched for any cities yet.</td>';
                                }
                            echo '</table>';
                            ?>
                        </div>
                        <span id="clearHistory-<?php echo $_SESSION["user_id"] ?>">Clear</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/fontawesome-all.js"></script>
    <script src="js/app.js"></script>
    <script type="text/javascript">
        <?php
        if($_SESSION["user_id"] > 0){
            echo 'var log_in = true;';
            $sql = "SELECT home FROM user_weather WHERE username = '".$_SESSION["username"]."'";
            $result = mysqli_query($link, $sql);
            while($row = $result->fetch_assoc()) {
                if($row["home"] == ""){
                    echo 'document.getElementById("homeCurrent").innerHTML += "<h3>You haven\'t set a home location yet!</h3>";';
                }else if($row["home"] != ""){
                    echo 'var city = "' . $row["home"]. '";';
                }
            }
        }else{
            echo 'var log_in = false;';
            echo 'document.getElementById("homeCurrent").innerHTML += "<h3>Please log in to set a home location!</h3>";';
        }
        ?>

        function check_login(){
            if(log_in){
                $("#nav-right").prepend('<h1 id="welcomeUser">Welcome, <?php echo ucfirst(strtolower($_SESSION["username"])) ?></h1>');
                $(".login").attr("href", "#").attr("class", "update").attr("data-target", "#update").attr("title", "Edit Profile").html('<i class="far fa-cog"></i> ');
                $(".register").attr("href", "logout.php").attr("class", "logout").attr("title", "Sign Out").removeAttr("data-toggle").removeAttr("data-target").html('<i class="far fa-sign-out"></i>');
            }
        }
        var arrayObjects = <?php echo $json_array2; ?>;

        $(document).ready(function() {
            check_login();
            historyCheck();

            $('td[data-city]').click(function(event) {
                var cityTD = $(this);
                var cityName = $(this).data('city');
                if (confirm("Are you sure you want to delete " + cityName + " from your history?")) {
                    $.ajax({
                        type: "POST",
                        url: "php/delete.php",
                        data: ({
                            id: <?php echo $_SESSION["user_id"] ?>,
                            city: cityName
                        }),
                        success: function() {
                            cityTD.closest("tr").html("");
                        }
                    });
                } else {
                    return false;
                }
            });


            // Delete entire history
            $('#clearHistory-<?php echo $_SESSION["user_id"] ?>').click(function(){
                var id = $(this).attr("id");
                var splitid = id.split("-");
                // Delete id
                var deleteid = splitid[1];
                if (confirm("Are you sure you want to clear your history?")) {
                    $.ajax({
                        type: "POST",
                        url: "php/history.php",
                        data: ({
                            id: deleteid
                        }),
                        success: function() {
                            $('#historyTable tbody').html("<tr><td>You haven't searched for any cities yet.</td></tr>");
                            // $("#historyTable tr").not(":first-child").html("");
                            // $('#historyTable tr:first-child').next().html("<td>You haven't searched for any cities.</td>");
                        }
                    });
                } else {
                    return false;
                }
            });
        });

        // Attach a submit handler to the form
        $( "#register_form" ).submit(function( event ) {
            event.preventDefault();
            $.post("php/register.php",
                {username:$("#usernameRegister").val(), password:$("#passwordRegister").val(), email:$("#emailRegister").val()},
                function(data){

                    console.log(data.status);

                    //reset any previous error messages
                    $("#username_error").html("");
                    $("#username_error").css("display","none");
                    $("#usernameRegister").css("border", "2px inset");
                    $("#password_error").html("");
                    $("#password_error").css("display","none");
                    $("#passwordRegister").css("border", "2px inset");
                    $("#email_error").html("");
                    $("#email_error").css("display","none");
                    $("#emailRegister").css("border", "2px inset");
                    $("#account_error").html("");
                    $("#account_error").css("display","none");

                    if(data.status === "success"){
                        window.location = "index.php";
                    }else{
                        if(data.username_error != null){
                            $("#username_error").html(data.username_error);
                            $("#username_error").css("display","block");
                            $("#usernameRegister").css("border", "2px solid red");
                        }
                        if(data.password_error != null){
                            $("#password_error").html(data.password_error);
                            $("#password_error").css("display","block");
                            $("#passwordRegister").css("border", "2px solid red");
                        }
                        if(data.email_error != null){
                            $("#email_error").html(data.email_error);
                            $("#email_error").css("display","block");
                            $("#emailRegister").css("border", "2px solid red");
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

        // Attach a submit handler to the form
        $( "#login_form" ).submit(function( event ) {
            event.preventDefault();
            $.post("php/login.php",
                {username:$("#usernameLogin").val(), password:$("#passwordLogin").val()},
                function(data){

                    //reset the error message
                    $("#login_error").html("");
                    $("#login_error").css("display","none");
                    $("#usernameLogin").css("border", "2px inset");
                    $("#passwordLogin").css("border", "2px inset");

                    if(data.status == "success"){
                        window.location = "index.php";
                    }else{
                        if(data.login_error != null){
                            $("#login_error").html(data.login_error);
                            $("#login_error").css("display","block");
                            $("#usernameLogin").css("border", "2px solid red");
                            $("#passwordLogin").css("border", "2px solid red");

                        }
                    }
                },
                "json"
            );
        });

        // Attach a submit handler to the form
        $( "#reset_form" ).submit(function( event ) {
            event.preventDefault();
            $.post("php/reset.php",
                {email:$("#emailReset").val()},
                function(data){

                    //reset the error messages
                    $("#user_message").html("");
                    $("#user_message").css("display","none");
                    $("#reset_error").html("");
                    $("#reset_error").css("display","none");

                    if(data.status == "success"){
                        if(data.user_message != null){
                            $("#user_message").html(data.user_message);
                            $("#user_message").css("display","block");
                        }
                    }else{
                        if(data.reset_error != null){
                            $("#reset_error").html(data.reset_error);
                            $("#reset_error").css("display","block");
                        }
                    }
                },
                "json"
            );
        });

        $('.modal').on('hidden.bs.modal', function (e) {
            // $(this).find('form')[0].reset();
            //reset any previous error messages
            $("#username_error").html("");
            $("#username_error").css("display","none");
            $("#usernameRegister").css("border", "2px inset");
            $("#password_error").html("");
            $("#password_error").css("display","none");
            $("#passwordRegister").css("border", "2px inset");
            $("#email_error").html("");
            $("#email_error").css("display","none");
            $("#emailRegister").css("border", "2px inset");
            $("#account_error").html("");
            $("#account_error").css("display","none");
            $("#login_error").html("");
            $("#login_error").css("display","none");
            $("#usernameLogin").css("border", "2px inset");
            $("#passwordLogin").css("border", "2px inset");
            $("#user_message").html("");
            $("#user_message").css("display","none");
            $("#email_error").html("");
            $("#email_error").css("display","none");
        });
    </script>
</body>
</html>