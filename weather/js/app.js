$(document).ready(function(){
    var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
    var baseURL = "http://api.openweathermap.org/data/2.5/group?id=";
    var city = "5368361,5128581,4140963";
    var fullURL = baseURL + city + "&units=imperial" + "&appid=" + apiKey;


    function weather(){
        $.ajax({
            url:fullURL,
            success: function(data){
                var wind = data.list[0].wind.deg;
                var wind1 = data.list[1].wind.deg;
                var wind2 = data.list[2].wind.deg;
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
                if(wind1 >= 0 && wind1 <= 11.25){
                    wind1 = "N"
                }else if(wind1 > 11.25 && wind1 <= 33.75){
                    wind1 = "NNE"
                }else if(wind1 > 33.75 && wind1 <= 56.25){
                    wind1 = "NE"
                }else if(wind1 > 56.25 && wind1 <= 78.75){
                    wind1 = "ENE"
                }else if(wind1 > 78.75 && wind1 <= 101.25){
                    wind1 = "E"
                }else if(wind1 > 101.25 && wind1 <= 123.75){
                    wind1 = "ESE"
                }else if(wind1 > 123.75 && wind1 <= 146.25){
                    wind1 = "SE"
                }else if(wind1 > 146.25 && wind1 <= 168.75){
                    wind1 = "SSE"
                }else if(wind1 > 168.75 && wind1 <= 191.25){
                    wind1 = "S"
                }else if(wind1 > 191.25 && wind1 <= 213.75){
                    wind1 = "SSW"
                }else if(wind1 > 213.75 && wind1 <= 236.25){
                    wind1 = "SW"
                }else if(wind1 > 236.25 && wind1 <= 258.75){
                    wind1 = "WSW"
                }else if(wind1 > 258.75 && wind1 <= 281.25){
                    wind1 = "W"
                }else if(wind1 > 281.25 && wind1 <= 303.75){
                    wind1 = "WNW"
                }else if(wind1 > 303.75 && wind1 <= 326.25){
                    wind1 = "NW"
                }else if(wind1 > 326.25 && wind1 <= 348.75){
                    wind1 = "NNW"
                }else if(wind1 > 348.75 && wind1 <= 360){
                    wind1 = "N"
                }else{
                    wind1 = "" //API outputs 'undefined' if a wind direction isn't observed. this circumvents that.
                }
                if(wind2 >= 0 && wind2 <= 11.25){
                    wind2 = "N"
                }else if(2 > 11.25 && wind2 <= 33.75){
                    wind2 = "NNE"
                }else if(wind2 > 33.75 && wind2 <= 56.25){
                    wind2 = "NE"
                }else if(wind2 > 56.25 && wind2 <= 78.75){
                    wind2 = "ENE"
                }else if(wind2 > 78.75 && wind2 <= 101.25){
                    wind2 = "E"
                }else if(wind2 > 101.25 && wind2 <= 123.75){
                    wind2 = "ESE"
                }else if(wind2 > 123.75 && wind2 <= 146.25){
                    wind2 = "SE"
                }else if(wind2 > 146.25 && wind2 <= 168.75){
                    wind2 = "SSE"
                }else if(wind2 > 168.75 && wind2 <= 191.25){
                    wind2 = "S"
                }else if(wind2 > 191.25 && wind2 <= 213.75){
                    wind2 = "SSW"
                }else if(wind2 > 213.75 && wind2 <= 236.25){
                    wind2 = "SW"
                }else if(wind2 > 236.25 && wind2 <= 258.75){
                    wind2 = "WSW"
                }else if(wind2 > 258.75 && wind2 <= 281.25){
                    wind2 = "W"
                }else if(wind2 > 281.25 && wind2 <= 303.75){
                    wind2 = "WNW"
                }else if(wind2 > 303.75 && wind2 <= 326.25){
                    wind2 = "NW"
                }else if(wind2 > 326.25 && wind2 <= 348.75){
                    wind2 = "NNW"
                }else if(wind2 > 348.75 && wind2 <= 360){
                    wind2 = "N"
                }else{
                    wind2 = "" //API outputs 'undefined' if a wind direction isn't observed. this circumvents that.
                }

                document.getElementById("content").innerHTML =
                    "<div id='cities'>" +
                        "<div class='cityInfo'>" +
                            "<h1 class='cityName'>" + data.list[0].name + "</h1>" +
                            "<div class='temp'><h3>" + Math.round(data.list[0].main.temp) +  "°F / " + Math.round( (data.list[0].main.temp - 32) * (5/9)) + "°C</h3></div>" +
                            "<div class='wind'><h3>Winds: " + wind + " " + Math.round( data.list[0].wind.speed ) + " MPH</h3></div>" +
                            "<div class='humidity'><h3>" + data.list[0].main.humidity + "% humidity</h3></div>" +
                            "<div class='sky'>" + "<h3>" + data.list[0].weather[0].description.charAt(0).toUpperCase() + data.list[0].weather[0].description.slice(1).toLowerCase() + "</h3> " + "<img src='http://openweathermap.org/img/w/" + data.list[0].weather[0].icon + ".png'>" + "</div>" +
                        "</div>" +
                        "<div class='cityInfo'>" +
                            "<h1 class='cityName'>" + data.list[1].name + "</h1>" +
                            "<div class='temp'><h3>" + Math.round(data.list[1].main.temp) +  "°F / " + Math.round( (data.list[1].main.temp - 32) * (5/9)) + "°C</h3></div>" +
                            "<div class='wind'><h3>Winds: " + wind1 + " " + Math.round( data.list[1].wind.speed ) + " MPH</h3></div>" +
                            "<div class='humidity'><h3>" + data.list[1].main.humidity + "% humidity</h3></div>" +
                    "<div class='sky'>" + "<h3>" + data.list[1].weather[0].description.charAt(0).toUpperCase() + data.list[1].weather[0].description.slice(1).toLowerCase() + "</h3> " + "<img src='http://openweathermap.org/img/w/" + data.list[1].weather[0].icon + ".png'>" + "</div>" +
                        "</div>" +
                        "<div class='cityInfo'>" +
                            "<h1 class='cityName'>" + data.list[2].name + "</h1>" +
                            "<div class='temp'><h3>" + Math.round(data.list[2].main.temp) +  "°F / " + Math.round( (data.list[2].main.temp - 32) * (5/9)) + "°C</h3></div>" +

                            "<div class='wind'><h3>Winds: " + wind2 + " " + Math.round( data.list[2].wind.speed ) + " MPH</h3></div>" +
                            "<div class='humidity'><h3>" + data.list[2].main.humidity + "% humidity</h3></div>" +
                            "<div class='sky'>" + "<h3>" + data.list[2].weather[0].description.charAt(0).toUpperCase() + data.list[2].weather[0].description.slice(1).toLowerCase() + "</h3> " + "<img src='http://openweathermap.org/img/w/" + data.list[2].weather[0].icon + ".png'>" + "</div>" +
                        "</div>" +
                    "</div>"
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

    weather();
});