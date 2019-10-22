var map;
var mapDiv = document.getElementById('map');
function initMap() {
	map = new google.maps.Map(mapDiv, {
		center: {lat: -8.654907, lng: 115.2189841},
		zoom: 14,
		scrollwheel: false,
		mapTypeId: 'roadmap',
		styles: [
		  {
		    "featureType": "landscape",
		    "stylers": [
		      { "color": "#f2e5d4" }
		    ]
		  },{
		    "featureType": "road.arterial",
		    "elementType": "geometry",
		    "stylers": [
		      { "color": "#e4d7c6" },
		      { "visibility": "simplified" }
		    ]
		  },{
		    "featureType": "road.highway",
		    "elementType": "geometry",
		    "stylers": [
		      { "color": "#c6c6c6" },
		      { "visibility": "simplified" }
		    ]
		  },{
		    "featureType": "road.local",
		    "elementType": "geometry",
		    "stylers": [
		      { "color": "#f6efe2" }
		    ]
		  },{
		    "featureType": "water",
		    "elementType": "geometry",
		    "stylers": [
		      { "color": "#aabbc9" }
		    ]
		  },{
		    "featureType": "poi.school",
		    "elementType": "labels.icon",
		    "stylers": [
		      { "color": "#b28080" }
		    ]
		  }
		]
	});
}
