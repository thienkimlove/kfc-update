var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(27.1959739, 78.02423269999997);
    var mapOptions = {
        zoom: 8,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById("googlemaps"), mapOptions);
}


function displayAddress(restaurants) {
    for (var i = 0 ; i < restaurants.length; i ++) {
        geocoder.geocode( { 'address': restaurants[i]}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
}
