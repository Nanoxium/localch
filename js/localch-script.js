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
var geocoder = null;
var userLocation = null;
var infowindow = null;


/**
 * Fonction qui va initialiser la carte de l'API GoogleMaps et les objets pour la carte
 */
function initializeMap() {
    var latLng = new google.maps.LatLng(46.2050242,6.1090691);
    var mapOptions = {
        zoom: 8,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapDiv"), mapOptions);
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
}

/**
 * Fonction qui affiche sur la carte la position et l'adresse d'une latitude et longitude
 * @param geocoder object de geocoding
 * @param map la carte sur laquelle afficher le point
 * @param infowindow l'infobulle
 */
function geocodeLatLng(geocoder, map, infowindow) {
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(11);
                marker = new google.maps.Marker({
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
 * @param address Adresse à géocoder
 * @param geocoder l'objet de géocodage
 * @param resultsMap la carte sur laquel va être positioné le marker
 */
function geocodeAddress(address) {

    geocoder.geocode({'address': address}, function(results, status) {
        //Vérifie si ça a fonctionné
        if (status === google.maps.GeocoderStatus.OK) {

            userLocation = results[0].geometry.location

            map.setCenter(userLocation);
            map
            marker = new google.maps.Marker({
                map: map,
                position: userLocation,
                title: address
            });
            infowindow.setContent(address)
            $('#location').val(userLocation.toString());
        } else {

        }
    });
}