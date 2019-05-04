"use strict";

var marker;
var map;
var geocoder;
var i = 0;

function setMarker(pos) {
	map.setCenter(pos);
	marker.setPosition(pos);
}

function localisation() {
	if (navigator.geolocation) {
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15
		});

		navigator.geolocation.getCurrentPosition(function (position) {
			var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

			marker = new google.maps.Marker({draggable: true});
			marker.setMap(map);
			setMarker(pos);
			document.getElementById("latitude").value = position.coords.latitude;
			document.getElementById("longitude").value = position.coords.longitude;
		}, function Erreur(error) {
			switch (error.code) {
				case (error.POSITION_UNAVAILABLE):
					{
						alert('Impossible de determiner la position !')
					}
					break;
				case (error.PERMISSION_DENIED):
					{
						alert('Geolocalisation non autorisée !')
					}
					break;
				case (error.TIMEOUT):
					{
						alert('Temps de chargement écoulé !')
					}
					break;
				case (error.UNKNOWN_ERROR):
					{
						alert('Erreur inconnue !')
					}
					break;
			}
		}, {

			enableHighAccuracy: true,
			maximumAge: 0
		});


	}

}




