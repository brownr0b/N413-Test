<?php
ini_set( "display_errors", 0);
include("php/n413connect.php");
session_start();
if(! isset($_SESSION["user_id"])){
    $_SESSION["user_id"] = 0;
    $_SESSION["username"] = "";
}

$city = "";
if(isset($_REQUEST["q"])){
    $city = html_entity_decode($_REQUEST["q"]);
    $city = trim($city);
    $city = stripslashes($city);
    $city = strip_tags($city);
    $city = strtok($city, ',');
    $city = mysqli_real_escape_string( $link, $city );
}

if($_SESSION["user_id"] > 0){
    if(is_nan($city)){
        $response = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='. $city .'&appid=65a1da2d3ac9918ebadc15f6678559d2');
    }else{
        $response = file_get_contents('https://api.openweathermap.org/data/2.5/weather?zip='. $city .'&appid=65a1da2d3ac9918ebadc15f6678559d2');
    }
    if($response){
        $sql = "INSERT INTO history_weather (`id`, `user_id`, `city`, `timestamp`) VALUES (NULL, '".$_SESSION["user_id"]."', '" . ucwords($city) . "', NOW() ) ON DUPLICATE KEY UPDATE timestamp = NOW() ;";
        $result = mysqli_query($link, $sql);
    }
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
    <link rel="stylesheet" href="css/city.css">
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
                <a href="#" class="register" data-toggle="modal" data-target="#register">Register</a>
                <a href="#" class="login" data-toggle="modal" data-target="#login">Login</a>
            </div>
        </nav>
        <div id="content"></div>
    </div>

    <div class="modal fade" id="register" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="far fa-times"></i></span></button>
                    <h4 class="modal-title">Register</h4>
                </div>
                <div class="modal-body">
                    <form id="register_form" name="register_form" class="form-horizontal" method="post" action="php/register.php">
                        <input type="text" placeholder="Username" name="username" id="username">
                        <input type="email" placeholder="Email" name="email" id="email">
                        <input type="password" placeholder="Password" name="password" id="password">
                        <button type="submit" name="register" id="registerbtn">Register</button>
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
                    <form id="login_form" name="login_form" class="form-horizontal"  method="post" action="php/login.php" >
                        <input type="text" placeholder="Username" name="username">
                        <input type="password" placeholder="Password" name="password">
                        <button type="submit" name="login" id="loginbtn">Log in</button>
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
                            <input type="password" name="password">
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
    <script src="js/app2.js"></script>
    <script type="text/javascript">
        var query = window.location.search.substring(3);
        function titleCase(str) {
            var query = str.toLowerCase().split(' ');
            for (var i = 0; i < query.length; i++) {
                query[i] = query[i].charAt(0).toUpperCase() + query[i].substring(1);
            }
            return query.join(' ');
        }
        document.title = titleCase(query) + " Weather Forecast & Conditions";
        if(query === ""){
            window.location.replace("index.php");
        }

        <?php
        if($_SESSION["user_id"] > 0){
            echo 'var log_in = true;';
        }else{
            echo 'var log_in = false;';
        }
        ?>


        function check_login(){
            if(log_in){
                $("#nav-right").prepend('<h1 id="welcomeUser">Welcome, <?php echo ucfirst(strtolower($_SESSION["username"])) ?></h1>');
                $(".login").attr("href", "logout.php").attr("class", "logout").attr("title", "Sign Out").removeAttr("data-toggle").html('<i class="far fa-sign-out"></i>');
                $(".register").attr("href", "#").attr("class", "update").attr("data-target", "#update").attr("title", "Edit Profile").html('<i class="far fa-cog"></i> ');
            }
        }

        $(document).ready(function() {
            check_login();

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

            // Delete
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
                            $('#citiesContainer').empty();
                            // $("#historyTable tr").not(":first-child").html("");
                            // $('#historyTable tr:first-child').next().html("<td>You haven't searched for any cities.</td>");
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    </script>
</body>
</html>