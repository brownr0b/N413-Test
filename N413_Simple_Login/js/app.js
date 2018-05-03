$(document).ready(function(){

    //displays a greeting based on the user's current time
    var time = new Date().getHours();
    if(time < 4){
        $(".greeting").html("Good Evening!")
    } else if(time >= 4 && time < 12){
        $(".greeting").html("Good Morning!")
    }else if(time >= 12 && time < 17){
        $(".greeting").html("Good Afternoon!")
    }else if(time >= 17){
        $(".greeting").html("Good Evening!")
    }

    $(".form").submit(function(){
        event.preventDefault();

        $("input").blur();

        //sets x as the value for the city/zip input by the user
        var x = $("#place").val();

        //if x is NaN (Not a Number), then the function that searches by city name is ran,
        // otherwise it will run the function that searches by zip code
        if (isNaN(x)){
            weatherCity();
        }else if(x === ""){

            //displays a red border around the input if the user tries to search with an empty input field
            $('input[type=text]').css("border", "2px solid red");
        }else{
            weatherZip();
        }

        //removes the red border once the user begins to type in the input field
        $("input[type=text]").keydown(function(e){
            $("input[type=text]").css("border", "2px solid white");
        });

        //////Old version that included two separate inputs
        // if( $("#city").val() !== "" && $("#zipcode").val() == "" ){
        //     weatherCity();
        //
        // }else if( $("#city").val() == "" && $("#zipcode").val() !== "" ){
        //     weatherZip();
        //
        // }else{
        //     $('input[type=text]').css("border", "2px solid red");
        // }
    });

    //once the back arrow is clicked on the result page, the page slides back to the search page
    $("#result").on("click", "div.back", function(){
        $("#search").animate({
            right: "0"
        }, 1500,  'easeInOutQuint');
        $("#result").animate({
            left: "100%"
        }, 1500,  'easeInOutQuint');

        //resets the form on back so the user won't have to clear the input themselves
        $(".form")[0].reset();

        //Gives the input focus so the user is able to immediately begin typing without clicking the field
        //$("#city").focus();
        $("#place").focus();

        //removes all styling and content from #result in order to slightly reduce load times and any graphical bugs that may arise
        setTimeout(function(){
            $("#result").html("");
            $("#result").removeAttr('style');
        }, 1500);
    });

    function weatherCity() {
        var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
        var baseURL = "https://api.openweathermap.org/data/2.5/weather?q=";
        //var city = $("#city").val();
        var city = $("#place").val();
        var fullURL = baseURL + city + "&units=imperial" + "&appid=" + apiKey;

        $.ajax({
            url:fullURL,
            success: function(data){

                //on success, removes the error displayed from a failed ajax call
                setTimeout(function(){
                    $(".error").html("");
                }, 1500);

                $("#search").animate({
                    right: "100%"
                }, 1500,  'easeInOutQuint');
                $("#result").animate({
                    left: "0"
                }, 1500,  'easeInOutQuint');

                //chooses a gradient based on the temperature of the city
                if(Math.round(data.main.temp) >= 60){
                    $("#result").css("background", "linear-gradient(45deg, #fc4a1a, #f7b733)")
                }else{
                    $("#result").css("background", "linear-gradient(45deg, #24c6dc, #514a9d)")
                }
                //assigns the value of the wind direction from the API to a cardinal direction
                var wind = data.wind.deg;
                if(wind >= 0 && wind <= 11.25){
                    wind = "N"
                }else if(wind > 11.25 && wind <= 33.75){
                    wind = "NNE"
                }else if(wind > 33.75 && wind <= 56.25){
                    wind = "NE"
                }else if(wind > 56.25 && wind <= 78.75){
                    wind = "ENE"
                }else if(wind > 78.75 && wind <= 101.25){
                    wind = "E"
                }else if(wind > 101.25 && wind <= 123.75){
                    wind = "ESE"
                }else if(wind > 123.75 && wind <= 146.25){
                    wind = "SE"
                }else if(wind > 146.25 && wind <= 168.75){
                    wind = "SSE"
                }else if(wind > 168.75 && wind <= 191.25){
                    wind = "S"
                }else if(wind > 191.25 && wind <= 213.75){
                    wind = "SSW"
                }else if(wind > 213.75 && wind <= 236.25){
                    wind = "SW"
                }else if(wind > 236.25 && wind <= 258.75){
                    wind = "WSW"
                }else if(wind > 258.75 && wind <= 281.25){
                    wind = "W"
                }else if(wind > 281.25 && wind <= 303.75){
                    wind = "WNW"
                }else if(wind > 303.75 && wind <= 326.25){
                    wind = "NW"
                }else if(wind > 326.25 && wind <= 348.75){
                    wind = "NNW"
                }else if(wind > 348.75 && wind <= 360){
                    wind = "N"
                }else{
                    wind = "" //API outputs 'undefined' if a wind direction isn't observed. this circumvents that.
                }

                var date = new Date(data.dt * 1000); //converts unix time to a readable format

                //displays the cities weather data to the page
                $("#result").html(
                    "<div class='back'><i class='fas fa-arrow-left fa-3x'></i></div>" +
                    "<div class='dataTime'><p>As of " + date + " </p></div>" +
                    "<div>" +
                    "<h1 class='cityName'>" + data.name + ", " + data.sys.country + "</h1>" +
                    "<div class='temp'><h2>" + Math.round(data.main.temp) +  "°F / " + Math.round( (data.main.temp - 32) * (5/9)) + "°C</h2></div>" +
                    "<div class='sky'><img src='http://openweathermap.org/img/w/" + data.weather[0].icon + ".png'>" + "<h2>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</h2> " + "</div>" +                    "<div class='wind'><h2>Winds: " + wind + " " + Math.round( data.wind.speed ) + "MPH</h2></div>" +
                    "<div class='humidity'><h2>" + data.main.humidity + "% humidity</h2></div>" +
                    "</div>"
                );
            },
            error: function(){

                //displays an error if the ajax call fails
                $(".error").html("City not found. Please try again.");
                //$("#city").focus();
                $("#place").focus();
            }
        });
    }

    function weatherZip() {
        var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
        var baseURL = "https://api.openweathermap.org/data/2.5/weather?zip=";
        //var zipcode = $("#zipcode").val();
        var zipcode = $("#place").val();
        var fullURL = baseURL + zipcode + "&units=imperial" + "&appid=" + apiKey;

        $.ajax({
            url:fullURL,
            success: function(data){
                setTimeout(function(){
                    $(".error").html("");
                }, 1500);

                $("#search").animate({
                    right: "100%"
                }, 1500,  'easeInOutQuint');
                $("#result").animate({
                    left: "0"
                }, 1500,  'easeInOutQuint');

                if(Math.round(data.main.temp) >= 60){
                    $("#result").css("background", "linear-gradient(45deg, #fc4a1a, #f7b733)")
                }else{
                    $("#result").css("background", "linear-gradient(45deg, #24c6dc, #514a9d)")
                }

                var wind = data.wind.deg;

                if(wind >= 0 && wind <= 11.25){
                    wind = "N"
                }else if(wind > 11.25 && wind <= 33.75){
                    wind = "NNE"
                }else if(wind > 33.75 && wind <= 56.25){
                    wind = "NE"
                }else if(wind > 56.25 && wind <= 78.75){
                    wind = "ENE"
                }else if(wind > 78.75 && wind <= 101.25){
                    wind = "E"
                }else if(wind > 101.25 && wind <= 123.75){
                    wind = "ESE"
                }else if(wind > 123.75 && wind <= 146.25){
                    wind = "SE"
                }else if(wind > 146.25 && wind <= 168.75){
                    wind = "SSE"
                }else if(wind > 168.75 && wind <= 191.25){
                    wind = "S"
                }else if(wind > 191.25 && wind <= 213.75){
                    wind = "SSW"
                }else if(wind > 213.75 && wind <= 236.25){
                    wind = "SW"
                }else if(wind > 236.25 && wind <= 258.75){
                    wind = "WSW"
                }else if(wind > 258.75 && wind <= 281.25){
                    wind = "W"
                }else if(wind > 281.25 && wind <= 303.75){
                    wind = "WNW"
                }else if(wind > 303.75 && wind <= 326.25){
                    wind = "NW"
                }else if(wind > 326.25 && wind <= 348.75){
                    wind = "NNW"
                }else if(wind > 348.75 && wind <= 360){
                    wind = "N"
                }

                var date = new Date(data.dt * 1000); //converts unix time to a readable format

                $("#result").html(
                    "<div class='back'><i class='fas fa-arrow-left fa-3x'></i></div>" +
                    "<div class='dataTime'><p>As of " + date + " </p></div>" +
                    "<div>" +
                    "<h1 class='cityName'>" + data.name + ", " + data.sys.country + "</h1>" +
                    "<div class='temp'><h2>" + Math.round(data.main.temp) +  "°F / " + Math.round( (data.main.temp - 32) * (5/9)) + "°C</h2></div>" +
                    "<div class='sky'><img src='http://openweathermap.org/img/w/" + data.weather[0].icon + ".png'>" + "<h2>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</h2> " + "</div>" +
                    "<div class='wind'><h2>Winds: " + wind + " " + Math.round( data.wind.speed ) + "MPH</h2></div>" +
                    "<div class='humidity'><h2>" + data.main.humidity + "% humidity</h2></div>" +
                    "</div>"
                );
            },
            error: function(){
                $(".error").html("Zipcode not found. Please try again.");
                $("#place").focus();
            }
        });
    }

});
