function UpdateBrowserData(){
    // Navigator
    document.getElementById("nav_AppName").innerHTML ="App Name: " + navigator.appName;
    document.getElementById("nav_product").innerHTML ="Product: " + navigator.product;
    document.getElementById("nav_appVersion").innerHTML ="App Version: " + navigator.appVersion;
    document.getElementById("nav_Useragreenment").innerHTML ="User Agreement: " + navigator.userAgent;
    // Window
    document.getElementById("win_innerHeight").innerHTML ="inner Height: " + window.innerHeight+"px";
    document.getElementById("win_innerWidth").innerHTML ="inner Width: " + window.innerWidth+"px";
    // Screen
    document.getElementById("screen_width").innerHTML ="Width: " + screen.width+"px";
    document.getElementById("screen_height").innerHTML ="Height: " + screen.height+"px";
    document.getElementById("screen_availWidth").innerHTML ="availWidth: " + screen.availWidth+"px";
    document.getElementById("screen_availHeight").innerHTML ="availHeight: " + screen.availHeight+"px";
    document.getElementById("screen_colorDepth").innerHTML ="colorDepth: " + screen.colorDepth;
    document.getElementById("screen_pixelDepth").innerHTML ="pixelDepth: " + screen.pixelDepth;
    // Location
    document.getElementById("location_hostname").innerHTML ="Hostname: " + location.hostname;
    document.getElementById("location_pathname").innerHTML ="PathName: " + location.pathname
    document.getElementById("location_protocol").innerHTML ="Protocol: " + location.protocol;
    // Geolocation
    // var latitude= document.getElementById("geo_latitude");
    // var longitude = document.getElementById("geo_longtitude");
    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            latitude.innerHTML = "Geolocation is not supported by this browser.";
            longitude.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        document.getElementById("geo_latitude").innerHTML = "Latitude: " + position.coords.latitude;
        document.getElementById("geo_longitude").innerHTML = "Longitude: " + position.coords.longitude;
    }
}