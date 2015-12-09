/*******************
 Auteurs : Jérôme Chételat / Philippe Ku
 Ecole/Classe : CFPT Informatique
 Date : 02.12.15
 Programme : Local.ch
 Fichier : script.js
 Version : 1.0
 *******************/

//Variables de "classe".
var map = null;
var marker = null;
var watchId = null;
var geocoder = null;
var userLocation = null;

/**
 * Fonction qui va démarrer la géolocalisation.
 * @returns {undefined}
 */
function startWatch() {
    $("#stop").removeAttr('disabled');
    $("#start").attr("disabled", "false");
    if (navigator.geolocation) {
        watchId = navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }
    else {
        alert("Votre navigateur ne prend pas en compte la géolocalisation HTML5");
    }
}

/**
 * Fonction qui va arrêter la géolocalisation.
 * @returns {undefined}
 */
function stopWatch() {
    $("#stop").attr("disabled", "true");
    $("#start").removeAttr("disabled");
    navigator.geolocation.clearWatch(watchId);
}

/**
 * Fonction qui va initialiser la carte de l'API GoogleMaps.
 * @returns {undefined}
 */
function initMap() {
    var latLng = new google.maps.LatLng(0, 0);
    var mapOptions = {
        zoom: 8,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapDiv"), mapOptions);
    geocoder = new google.maps.Geocoder();
}

/**
 * Fonction qui va afficher si la géolocalisation à réussi les valeurs de la géolocalisation ainsi q'un marqueur de position sur la carte.
 * @param {type} position
 * @returns {undefined}
 */
function successCallback(position) {
    if (marker != null)
        marker.setMap(null);
    $("#lat").text(position.coords.latitude);
    $("#long").text(position.coords.longitude);
    $("#prec").text(position.coords.accuracy);
    $("#alt").text(position.coords.altitude);
    $("#precalt").text(position.coords.altitudeAccuracy);
    $("#angle").text(position.coords.heading);
    $("#speed").text(position.coords.speed);
    $("#time").text(new Date(position.timestamp));

    var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
    };

    map.panTo(pos);

    marker = new google.maps.Marker({
        position: pos,
        map: map
    });
}

/**
 * Fonction qui va afficher un message d'erreur, si les permissions sont refusées, si la position est indisponible ou si le temps à expiré.
 * @param {type} error
 * @returns {undefined}
 */
function errorCallback(error) {
    switch (error.code) {
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

/**
 * Fonction qui recherche une latitude et longitude selon l'adresse fournie
 * @param address
 */
function geocodeAddress(address) {
    var loc = null;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK)
        {
            loc = results[0].geometry.location;
        }
        else
        {
            alert('Le geocode ne fonctionne pas car ' + status);
        }
    });

    return loc;
}

/**
 * Fonction qui affiche sur la carte la position et l'adresse d'une latitude et longitude
 * @param geocoder object de geocoding
 * @param map la carte sur laquelle afficher le point
 * @param infowindow l'infobulle
 */
function geocodeLatLng(geocoder, map, infowindow) {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(11);
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                infowindow.setContent(results[1].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}


/**
 * Fonction qui affiche sur la carte une postion à partir d'une adresse
 * @param address
 * @param geocoder
 * @param resultsMap
 */
function geocodeAddress(address, geocoder, resultsMap) {
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            userLocation = results[0].geometry.location
            resultsMap.setCenter(userLocation);
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: userLocation
            });
            $('#location').val(userLocation);
        } else {

        }
    });
}