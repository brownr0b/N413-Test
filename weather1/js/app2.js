$(document).ready(function(){

    var city = query;
    var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";

    $('#geolocation').click(function(){
        $('#geolocation').html( "<i class='far fa-spinner fa-spin'></i>" );
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

        function showPosition(pos){
            var lat = pos.coords.latitude;
            var lon =  pos.coords.longitude;
            var geoURL = "https://api.openweathermap.org/data/2.5/weather?lat=" + lat + "&lon=" + lon + "&appid=" + apiKey;

            $.ajax({
                url:geoURL,
                success: function(data){
                    $('#geolocation').html( "<i class='far fa-location-arrow'></i>" );
                    document.getElementById('place').value = data.name;
                },
                error: function(){
                    console.log("Couldn't access openweathermap API");
                }
            })
        }

        function showError(error) {
            $('#geolocation').html( "<i class='far fa-location-arrow'></i>" );
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }
    });

    var weatherIcons = (function() {
        $.ajax({
            async: false,
            global: false,
            url: "icons.json",
            dataType: "json",
            success: function (data) {
                weatherIcons = data;
            }
        });
        return weatherIcons;
    })();

    if (isNaN(city)){
        weatherCity();
    }else{
        weatherZip();
    }


    function weatherCity(){
        var baseURL = "https://api.openweathermap.org/data/2.5/weather?q=";
        var fullCity = baseURL + city + "&units=imperial" + "&appid=" + apiKey;

        $.ajax({
            url:fullCity,
            success: function(data){

                var date = new Date(data.dt * 1000);
                var prefix = 'wi wi-owm-';
                var code = data.weather[0].id;
                var weatherIcon = weatherIcons[code].icon;
                var hrs = date.getHours();
                if ( hrs > 6 && hrs < 20) {
                    weatherIcon = 'day-' + code;
                }else{
                    weatherIcon = 'night-' + code;
                }
                weatherIcon = prefix + weatherIcon;

                if(Math.round(data.main.temp) >= 60){
                    $("body").css("background", "linear-gradient(315deg, #fc4a1a, #f7b733)")
                }else{
                    $("body").css("background", "linear-gradient(135deg, #24c6dc, #514a9d)")
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
                    wind = "" //API outputs 'undefined' if a wind direction isn't observed. this keeps thing tidy
                }

                document.getElementById("content").innerHTML =
                    "<div class='cityInfo'>" +
                    "<h1 class='cityName'>" + data.name + ", " + data.sys.country + "</h1>" +
                    "<div class='temp'><p>Currently " + Math.round(data.main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div class='sky'><i class='"+ weatherIcon +"'></i><p>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</p></div>" +
                    "<div class='wind'><p>Winds: " + wind + " " + Math.round( data.wind.speed ) + " MPH <i class='wi wi-wind-direction wi-from-" + wind.toLowerCase() + "'></i></p></div>" +
                    "<div class='humidity'><p>" + data.main.humidity + "% humidity</p></div>" +
                    "<form method='post' action='php/home.php' class='homeForm'><input type='hidden' name='homeCity' value='" + data.name + "'><button type='submit' class='setHome'>set home</button></form>" +
                    "</div>" +
                    "<div class='dataTime'><p>As of " + date + "</p></div>"
                ;
            },
            error: function(){
                document.getElementById("content").innerHTML =
                    "<h1 class='cityName'>Your search yielded no results.</h1>" +
                    "<a href='index.php'>Return</a>"
                ;
                $("body").css("background", "linear-gradient(-20deg, #b721ff 0%, #21d4fd 100%)");
            }
        });
    }

    function weatherZip(){

        var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
        var baseURL = "https://api.openweathermap.org/data/2.5/weather?zip=";
        var zip = query;
        var fullZip = baseURL + zip + "&units=imperial" + "&appid=" + apiKey;
        $.ajax({
            url:fullZip,
            success: function(data){

                var date = new Date(data.dt * 1000);
                var prefix = 'wi wi-owm-';
                var code = data.weather[0].id;
                var weatherIcon = weatherIcons[code].icon;
                var hrs = date.getHours();
                if ( hrs > 6 && hrs < 20) {
                    weatherIcon = 'day-' + code;
                }else{
                    weatherIcon = 'night-' + code;
                }
                weatherIcon = prefix + weatherIcon;

                if(Math.round(data.main.temp) >= 60){
                    $("body").css("background", "linear-gradient(315deg, #fc4a1a, #f7b733)")
                }else{
                    $("body").css("background", "linear-gradient(135deg, #24c6dc, #514a9d)")
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
                    wind = "" //API outputs 'undefined' if a wind direction isn't observed. this keeps thing tidy
                }

                document.getElementById("content").innerHTML =
                    "<div class='cityInfo'>" +
                    "<h1 class='cityName'>" + data.name + ", " + data.sys.country + "</h1>" +
                    "<div class='temp'><p>" + Math.round(data.main.temp) +  "<i class='wi wi-fahrenheit'></i>/ " + Math.round( (data.main.temp - 32) * (5/9)) + "°<i class='wi wi-celsius'></i></p></div>" +
                    "<div class='sky'><i class='"+ weatherIcon +"'></i><p>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</p></div>" +
                    "<div class='wind'><p>Winds: " + wind + " " + Math.round( data.wind.speed ) + " MPH <i class='wi wi-wind-direction wi-from-" + wind.toLowerCase() + "'></i></p></div>" +
                    "<div class='humidity'><p>" + data.main.humidity + "% humidity</p></div>" +
                    "</div>" +
                    "<form method='post' action='php/home.php' class='homeForm'><input type='hidden' name='homeCity' value='" + data.name + "'><button type='submit' class='setHome'>set home</button></form>" +
                    "<div class='dataTime'><p>As of " + date + "</p></div>"
                ;
            },
            error: function(){
                document.getElementById("content").innerHTML =
                    "<h1 class='cityName'>Your search yielded no results.</h1>" +
                    "<a href='index.php'>Return</a>"
                ;
                $("body").css("background", "linear-gradient(135deg, #24c6dc, #514a9d)");
            }
        });
    }
});