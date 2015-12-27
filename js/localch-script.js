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
var markers = [];
var geocoder = null;
var infowindow = null;

/**
 * Fonction qui va initialiser la carte de l'API GoogleMaps et les objets pour la carte
 */
function initializeMap(id) {
    var latLng = new google.maps.LatLng(46.2050242, 6.1090691);
    var mapOptions = {
        zoom: 8,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById(id), mapOptions);
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
}

/**
 * Ajoute un marker
 * @param latlng
 * @param title
 */
function addMarker(latlng, title, content) {
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: title
    });
    marker.addListener('click', function () {
        infowindow.setContent(marker.title);
        infowindow.open(map, marker);
    });
    markers.push(marker);
}

/**
 * Afficher sur la carte les marker dans la liste des markers
 * @param map
 */
function setMapOnAllMarker(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

/**
 * Enlève les marker sur la carte
 */
function clearMarkersMap() {
    setMapOnAllMarker(null);
}

/**
 * Supprime tout les marker
 */
function deleteMarkers() {
    clearMarkersMap();
    markers = [];
}

function displayAllUsers()
{
    $.post("getUsers.php", function (result){
        var users = JSON.parse(result);
        for(var i = 0; i < users.length; i++)
        {
            //Parse the floating numbers
            var latlng = users[i].latlng.match(/[-+]?([0-9]*\.[0-9]+|[0-9]+)/g);
            addMarker(new google.maps.LatLng(latlng[0], latlng[1]), users[i].lastname + " " + users[i].firstname, users.address);
        }
    });
    setMapOnAllMarker(map);
}

/**
 * Fonction qui affiche sur la carte la position et l'adresse d'une latitude et longitude
 * @param geocoder object de geocoding
 * @param map la carte sur laquelle afficher le point
 * @param infowindow l'infobulle
 */
function geocodeLatLng(latlng, addMarkerToMap) {
    var tmpaddress;
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(11);
                if (addMarkerToMap) {
                    addMarker(latlng, results[0].formatted_address, results[0].formatted_address);
                }
                $('#address').val(results[0].formatted_address);
                $('#send').removeAttr("disabled");
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
 * @param address Adresse à géocoder
 * @param geocoder l'objet de géocodage
 * @param resultsMap la carte sur laquel va être positioné le marker
 */
function geocodeAddress(address) {

    geocoder.geocode({'address': address}, function (results, status) {
        //Vérifie si ça le geocogind a fonctionné
        if (status === google.maps.GeocoderStatus.OK) {
            //récupère la position en latitude et longitude
            var userLocation = results[0].geometry.location;
            map.setCenter(userLocation);
            clearMarkersMap();
            var newAddress = geocodeLatLng(userLocation, true);
            $('#location').val(userLocation.toString());
        }
    });
}
