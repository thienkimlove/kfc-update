var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(27.1959739, 78.02423269999997);
    var mapOptions = {
        zoom: 16, // initialize zoom level - the max value is 21
        streetViewControl: false, // hide the yellow Street View pegman
        scaleControl: true, // allow users to zoom the Google Map
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: latlng
    };
    map = new google.maps.Map(document.getElementById("googlemaps"), mapOptions);
}


function displayAddress(restaurants) {
    for (var i = 0 ; i < restaurants.length; i ++) {
        var marker = new google.maps.Marker({
            map: map,
            position: [restaurants[i].lat, restaurants[i].lon]
        });
    }
}
