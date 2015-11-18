//Variable de "classe"
var map = null;
var marker = null;
var watchId = null;

function startWatch() {
    $("#stop").removeAttr('disabled');
    $("#start").attr("disabled", "false");
    if (navigator.geolocation)
    {
        watchId = navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {enableHighAccuracy: true, timeout: 10000, maximumAge: 0});
    }
    else
    {
        alert("Votre navigateur ne prend pas en compte la géolocalisation HTML5");
    }
}

function initMap()
{
    var latLng = new google.maps.LatLng(0,0);
    var mapOptions = {
        zoom: 8,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    map = new google.maps.Map(document.getElementById("mapDiv"), mapOptions);
}

function stopWatch() {
    $("#stop").attr("disabled", "true");
    $("#start").removeAttr("disabled");
    navigator.geolocation.clearWatch(watchId);
}

function successCallback(position)
{
    if(marker != null)
        marker.setMap(null);
    $("#lat").text(position.coords.latitude);
    $("#long").text(position.coords.longitude);
    $("#prec").text(position.coords.accuracy);
    $("#alt").text(position.coords.altitude);
    $("#precalt").text(position.coords.altitudeAccuracy);
    $("#angle").text(position.coords.heading);
    $("#speed").text(position.coords.speed);
    $("#time").text(new Date(position.timestamp));

    var pos = {lat: position.coords.latitude,
        lng: position.coords.longitude};

    map.panTo(pos);

    marker = new google.maps.Marker({
        position: pos,
        map: map
    });
}

function errorCallback(error)
{
    switch (error.code)
    {
        case error.PERMISSION_DENIED:
            alert("L'utilisateur n'a pas autorisé l'accès à sa position");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("L'emplacement de l'utilisateur n'a pas pu être déterminé");
            break;
        case error.TIMEOUT:
            alert("Le service n'a pas répondu à temps");
            break;
        default:
            alert("Erreur de géolocalisation");
            break;
    }
}