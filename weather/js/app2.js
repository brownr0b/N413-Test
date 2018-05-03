$(document).ready(function(){

    var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
    var baseURL = "https://api.openweathermap.org/data/2.5/weather?q=";
    var city = query;
    var fullURL = baseURL + city + "&units=imperial" + "&appid=" + apiKey;

    if (isNaN(city)){
        weatherCity();
    }else{
        weatherZip();
    }


    function weatherCity(){
        $.ajax({
            url:fullURL,
            success: function(data){

                if(Math.round(data.main.temp) >= 60){
                    $("body").css("background", "linear-gradient(45deg, #fc4a1a, #f7b733)")
                }else{
                    $("body").css("background", "linear-gradient(45deg, #24c6dc, #514a9d)")
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

                var date = new Date(data.dt * 1000);

                document.getElementById("result").innerHTML =
                    "<div class='cityInfo'>" +
                    "<h1 class='cityName'>" + data.name + ", " + data.sys.country + "</h1>" +
                    "<div class='temp'><h3>" + Math.round(data.main.temp) +  "°F / " + Math.round( (data.main.temp - 32) * (5/9)) + "°C</h3></div>" +
                    "<div class='sky'><img src='http://openweathermap.org/img/w/" + data.weather[0].icon + ".png'>" + "<h3>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</h3> " + "</div>" +
                    "<div class='wind'><h3>Winds: " + wind + " " + Math.round( data.wind.speed ) + " MPH</h3></div>" +
                    "<div class='humidity'><h3>" + data.main.humidity + "% humidity</h3></div>" +
                    "</div>" +
                    "<div class='dataTime'><p>As of " + date + " </p></div>"
                ;
            },
            error: function(){
                document.getElementById("result").innerHTML =
                    "<h1 class='cityName'>Your search yielded no results.</h1>"
                ;
                $("body").css("background", "linear-gradient(45deg, #24c6dc, #514a9d)");
            }
        });
    }

    function weatherZip(){

    }
});