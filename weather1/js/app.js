var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";

function historyCheck(){
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


    for (i = 0; i < arrayObjects.length; i++) {
        $.ajax({
            url: 'https://api.openweathermap.org/data/2.5/weather',
            async: false,
            data: {
                q: arrayObjects[i],
                units: 'imperial',
                appid: "65a1da2d3ac9918ebadc15f6678559d2"
            },
            success: function(data){
                var city = new Date(data.dt * 1000);
                var prefix = 'wi wi-owm-';
                var code = data.weather[0].id;
                var cityIcon = weatherIcons[code].icon;
                var owm = city.getHours();
                if ( owm > 6 && owm < 20) {
                    cityIcon = 'day-' + code;
                }else{
                    cityIcon = 'night-' + code;
                }
                cityIcon = prefix + cityIcon;

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
                document.getElementById("citiesContainer").innerHTML +=
                    "<div class='cityInfo'>" +
                    "<div class='background'><i class='" + cityIcon + "'></i></div>" +
                    "<div class='cityName'><a href='city.php?q=" + data.name + "' title='" + data.name + "'>" + data.name + ", " + data.sys.country + "</a></div>" +
                    "<div class='temp'><p>" + Math.round(data.main.temp) + "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div class='wind'><p>" + wind + " " + Math.round( data.wind.speed ) + " MPH </p></div>" +
                    "<div class='humidity'><p>" + data.main.humidity + "% humidity</p></div>" +
                    "<div class='sky'><i class='" + cityIcon + "' title='" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "'></i>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</div>" +
                    "<form method='post' action='php/home.php' class='homeForm'><input type='hidden' name='homeCity' value='" + data.name + "'><button type='submit' class='setHome'>set home</button></form>" +
                    "</div>"
            }
        })
    }
}

$(document).ready(function(){

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

    function forecast(){

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

        var baseURL = "https://api.openweathermap.org/data/2.5/weather?q=";
        var apiKey = "65a1da2d3ac9918ebadc15f6678559d2";
        var fullCity = baseURL + city + "&units=imperial" + "&appid=" + apiKey;

        var baseURL1 = "https://api.openweathermap.org/data/2.5/forecast?q=";
        var apiKey1 = "65a1da2d3ac9918ebadc15f6678559d2";
        var fullCity1 = baseURL1 + city + "&units=imperial&appid=" + apiKey1;

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

                document.getElementById("homeCurrent").innerHTML +=
                    "<div>" +
                    "<p>Home</p>" +
                    "<h2><a href='city.php?q=" + data.name + "' title='" + data.name + "'>" + data.name + ", " + data.sys.country + "</a></h2>" +
                    "<div class='temp'><p>Currently " + Math.round(data.main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div class='wind'><p>" + wind + " " + Math.round( data.wind.speed ) + " MPH <i class='wi wi-wind-direction wi-from-" + wind.toLowerCase() + "'></i></p></div>" +
                    "<div class='weather'><i class='"+ weatherIcon +"' title='" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "'></i>" + data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1).toLowerCase() + "</div>" +
                    "</div>"
                ;
            },
            error: function(){
            }
        });

        $.ajax({
            url:fullCity1,
            success: function(data){

                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June",
                    "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];

                var three = new Date(data.list[0].dt * 1000);
                var threeDay = monthNames[three.getMonth()] + " " + three.getDate();
                var threeTime = three.toLocaleString('en-US', { hour: 'numeric', hour12: true });

                var six = new Date(data.list[1].dt * 1000);
                var sixDay = monthNames[six.getMonth()] + " " + six.getDate();
                var sixTime = six.toLocaleString('en-US', { hour: 'numeric', hour12: true });

                var nine = new Date(data.list[2].dt * 1000);
                var nineDay = monthNames[nine.getMonth()] + " " + nine.getDate();
                var nineTime = nine.toLocaleString('en-US', { hour: 'numeric', hour12: true });

                var twelve = new Date(data.list[3].dt * 1000);
                var twelveDay = monthNames[twelve.getMonth()] + " " + twelve.getDate();
                var twelveTime = twelve.toLocaleString('en-US', { hour: 'numeric', hour12: true });

                var prefix = 'wi wi-owm-';
                var code = data.list[0].weather[0].id;
                var code1 = data.list[1].weather[0].id;
                var code2 = data.list[2].weather[0].id;
                var code3 = data.list[3].weather[0].id;

                var iconThree = weatherIcons[code].icon;
                var iconSix = weatherIcons[code1].icon;
                var iconNine = weatherIcons[code2].icon;
                var iconTwelve = weatherIcons[code3].icon;

                var owmThree = three.getHours();
                var owmSix = six.getHours();
                var owmNine = nine.getHours();
                var owmTwelve = twelve.getHours();

                if ( owmThree > 6 && owmThree < 20) {
                    iconThree = 'day-' + code;
                }else{
                    iconThree = 'night-' + code;
                }
                if ( owmSix > 6 && owmSix < 20) {
                    iconSix = 'day-' + code1;
                }else{
                    iconSix = 'night-' + code1;
                }
                if ( owmNine > 6 && owmNine < 20) {
                    iconNine = 'day-' + code2;
                }else{
                    iconNine = 'night-' + code2;
                }
                if ( owmTwelve > 6 && owmTwelve < 20) {
                    iconTwelve = 'day-' + code3;
                }else{
                    iconTwelve = 'night-' + code3;
                }

                iconThree = prefix + iconThree;
                iconSix = prefix + iconSix;
                iconNine = prefix + iconNine;
                iconTwelve = prefix + iconTwelve;

                document.getElementById("homeForecast").innerHTML +=
                    "<div id='forecastTitle'>Next 12 Hours</div>" +
                    "<div id='next12'>" +
                    "<div class='forecast'>" +
                    "<div><p>" + threeTime + "</p></div>" +
                    "<div><p>" + threeDay + "</p></div>" +
                    "<div><p>" + Math.round(data.list[0].main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div><i class='"+ iconThree +"' title='" + data.list[0].weather[0].description.charAt(0).toUpperCase() + data.list[0].weather[0].description.slice(1).toLowerCase() + "'></i></div>" +
                    "</div>" +
                    "<div class='forecast'>" +
                    "<div><p>" + sixTime + "</p></div>" +
                    "<div><p>" + sixDay + "</p></div>" +
                    "<div><p>" + Math.round(data.list[1].main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div><i class='"+ iconSix +"' title='" + data.list[1].weather[0].description.charAt(0).toUpperCase() + data.list[1].weather[0].description.slice(1).toLowerCase() + "'></i></div>" +
                    "</div>" +
                    "<div class='forecast'>" +
                    "<div><p>" + nineTime + "</p></div>" +
                    "<div><p>" + nineDay + "</p></div>" +
                    "<div><p>" + Math.round(data.list[2].main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div><i class='"+ iconNine +"' title='" + data.list[2].weather[0].description.charAt(0).toUpperCase() + data.list[2].weather[0].description.slice(1).toLowerCase() + "'></i></div>" +
                    "</div>" +
                    "<div class='forecast'>" +
                    "<div><p>" + twelveTime + "</p></div>" +
                    "<div><p>" + twelveDay + "</p></div>" +
                    "<div><p>" + Math.round(data.list[3].main.temp) +  "<i class='wi wi-fahrenheit'></i></p></div>" +
                    "<div><i class='"+ iconTwelve +"' title='" + data.list[3].weather[0].description.charAt(0).toUpperCase() + data.list[3].weather[0].description.slice(1).toLowerCase() + "'></i></div>" +
                    "</div>" +
                    "</div>"
                ;

            },
            error: function(){
            }
        });
    }

    forecast();
});