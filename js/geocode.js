"use strict";

function geocode(){
	var address_raw = document.getElementById("address").value;
    var address = address_raw.split('\n');
    var seuil = 5;
    document.getElementById('infos').innerHTML = "";
    document.getElementById('résultats').innerHTML = "";
    document.getElementById('infos').innerHTML += address.length + " requêtes saisies : ";
    for (var i = 0; i < address.length; i++)
    {
 
    //ce bout là limite le nombre de requêtes envoyées simultanément pour éviter une erreur du type OVER QUERY LIMIT
	if (i%seuil == 0 && i > seuil) {alert(i + " requêtes passées sur " + address.length);}
    //on demande les coordonnées au gentil google
    	geocoder.geocode( { 'address': address[i]}, 
	function(results, status) 
	{
		if (status == google.maps.GeocoderStatus.OK) 
		{
			document.getElementById('résultats').innerHTML += results[0].geometry.location;
 
		}
		else {alert("Ça marche pas parce que " + status);}
	});
    	}
    }


