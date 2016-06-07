var restaurant = [{"id":"254","boss_code":"74020479","name":"KFC Jupiter","director_name":"Tatyana Golenkova","greeting":"Welcome to my restaurant!","address":"Gogol st., 15","city_id":"11","city_name":"Novosibirsk","country_id":"4","breakfast_time":"09:00-11:00","breakfast":"1","old_restaurant_id":"259","country_name":"Russia","site_code":"ru","value":"Novosibirsk, Gogol st., 15, Sibirskaya","start_time":"09:00","finish_time":"00:00","promo":"1","phone":"8-(800)-555-8-333","ext_phone":"5370, 5369","wifi":"1","provider_name":"Beeline","provider_id":"1","provider_rules":"beeline.php","round_the_clock":"0","car_distribution":"0","lat":"55.043154","lon":"82.92405","coupon_email":"RU-NSYupiter@kfc.com","email":"RU-NSYupiter@kfc.com","company_id":"1","photo":null,"director_original_photo":"http:\/\/static.kfc.ru\/restaurants_directors\/original\/","director_thumb_photo":"http:\/\/static.kfc.ru\/restaurants_directors\/thumb\/","director_middle_photo":"http:\/\/static.kfc.ru\/restaurants_directors\/middle\/","corporative":"1","excursion":"1","degustation":"0","count_people_in_excursion":"20","count_people_in_degustation":"0","shipping_coordinates":null,"shipping_color":null,"takeaway":"0","cashdesk_folder":null,"cashdesk_id":null,"post_index":"630005","opening_soon":"0","subway_stations":[{"id":"272","color":"#008000","name":"Sibirskaya"}],"share_url":"http:\/\/www.kfc.ru\/en\/restaurants\/254","distance":0}];
var nearest_restaurant;
var restaurant_id = '';
var current_location;
var current_destination;
var current_mode;
// Geocoding variable
var geocoder = new google.maps.Geocoder();
// Show route for drivers
var driving_mode = google.maps.TravelMode.DRIVING;
// Show route for pedesterians
var walking_mode = google.maps.TravelMode.WALKING;
var markerClusterer;
// Array of markers
var markers = [];
// Primary map options
var mapOptions = {
    disableDefaultUI: true,
    panControl: false,
    zoomControl: true,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    overviewMapControl: false,
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};
// Directions on restaurants map
var directionsDisplay;
// Map creation
var map = new google.maps.Map(document.getElementById("map"),
    mapOptions);
// Capital
var capital_boundpoints = [];
var capital_bounds = new google.maps.LatLngBounds();
// Capital identificator
var capital_id = 4;
var icon1 = "/frontend/images/placemark-red.png";
// Filters array contains all filter names we need
// var filters = ['wifi', 'excursion', 'takeaway', 'schedule', 'breakfast', 'promo', 'route'];
var filters = ['wifi', 'schedule', 'breakfast', 'promo', 'route', 'takeaway'];
var map_bar = $('.amenities-nav');


/* -------------------
 Filters block
 ----------------------*/

// Autocomplete of search field
$(".search").on("keyup", function(event) {
    //
})
    .autocomplete({
        minLength: 0,
        source: restaurants,
        focus: function(event, ui) {
            $(".search").val(ui.item.value);
            return false;
        },
        select: function(event, ui) {
            $(".search").val(ui.item.value);
            // Hide rows in table of restaurants
            data_filter([ui.item]);
            // Get map with current restaurant
            place_markers([ui.item],ui.item.id);
            return false;
        },
    })
    .data("autocomplete")._renderItem = function(ul, item) {
    return $( "<li>" )
        .data( "item.autocomplete", item )
        .append("<a>" + item.value + "</a>")
        .appendTo(ul);
};



// Filters for restaurants list
function data_filter(restaurants) {
    $('.restaurant-info').hide();
    $('#info-message').hide();

    for (var i in restaurants) {
        var distance_data = $('#row-' + restaurants[i].id + '').find('.distance');
        // Set distance to list items
        if (restaurants[i].distance_human != undefined) {
            distance_data.empty().append(restaurants[i].distance_human + ' from you');
        }
        $('#row-' + restaurants[i].id + '').show();
    }
    // In case if nothing found
    // Show appropriate message
    if (restaurants.length == 0)
    {
        $('#info-message').show();
    }

}

function set_filters_state(filter, state){
    $.each(filters, function( index, value ) {
        if (value != filter) {
            $('#' + value).data("value", state);
        }
    });
}

$('.filters').on('click', function(){
    var a = $(this).find('a');
    click_filter_button(a[0].id, $(this));
});

$('#show-all').on("click", $(this), function(){
    var map_bar = $('.map-bar');
    set_filters_state(null, 0);
    $(".search").data("value",'');
    $('#show-all').data('state','1');
    map_bar.find('.m-ico').removeClass('current');
    data_filter(restaurants_filter(restaurants));
    place_markers(restaurants_filter(restaurants));
    remove_marker();
});


function click_filter_button(field, object) {
    if ($('#' + field).data('value') == 0) {
        $('#' + field).data("value",'1');
        $(object).addClass('current');
        $('#show-all').data('state','0');
    }
    else if ($('#' + field).data('value') == 1) {
        if ($('#show-all').data('state') == 1)
        {
            $('.m-ico').removeClass('current');
            $(object).addClass('current');
            set_filters_state('schedule', '0');
        }
        else
        {
            $(object).removeClass('current');
            $('#' + field).data('value', 0);
        }
        $('#show-all').data('state','0');
    }
    data_filter(restaurants_filter(restaurants));
    place_markers(restaurants_filter(restaurants));
    remove_marker();
}

function where_enabled(collection, filters) {
    filters = _.pick(filters, function(value) {
        return (value != '0')
    })

    console.log(filters);
    return _.where(collection, filters)
}

function get_restaurants_by_subway(subway_id){
    return _.where(restaurants, { 'subway_stations_ids': ['' + subway_id + ''] });
}


function restaurants_filter(restaurants) {
    return where_enabled(restaurants, {
        car_distribution: $('#route').data('value'),
        promo: $('#promo').data('value'),
        round_the_clock: $('#schedule').data('value'),
        breakfast: "" + $('#breakfast').data('value') + "",
        wifi: $('#wifi').data('value'),
        // excursion: $('#excursion').data('value'),
        takeaway: $('#takeaway').data('value'),
    })
}


/*
 * Math part
 * Find the distance between the two latitude and longitude coordinates
 * Where the latitude and longitude coordinates are in decimal degrees format.
 */
function haversine_distance(lat1,lon1,lat2,lon2) {
    deltaLat = lat2 - lat1;
    deltaLon = lon2 - lon1;
    earthRadius = 6371; // In miles (6371 in kilometers)
    alpha = deltaLat/2;
    beta = deltaLon/2;
    a = Math.sin(deg2rad(alpha)) * Math.sin(deg2rad(alpha))
        + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2))
        * Math.sin(deg2rad(beta)) * Math.sin(deg2rad(beta));
    c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    distance = earthRadius * c;
    return distance.toFixed(4);
}

// Convert degrees to radians
function deg2rad(degrees){
    radians = degrees * (Math.PI/180);
    return radians;
}


function clearClusters(e) {
    markerClusterer.clearMarkers();
}

// Routes. Calculating route from point START to point END.
// Travel mode variable determines type of route (DRIVING, BYCICLING, WALKING)
function calc_route(start, end, travel_mode) {
    var directionsService = new google.maps.DirectionsService();
    // We should remove previous route
    if(directionsDisplay)
    {
        directionsDisplay.setMap(null);
    }
    // Creation of new direction
    directionsDisplay = new google.maps.DirectionsRenderer();
    // Set options
    directionsDisplay.setOptions( {
        suppressMarkers: true ,
        strokeColor:'#C4122F'
    } );
    directionsDisplay.setMap(map);
    var request = {
        origin:start,
        destination:end,
        travelMode: travel_mode
    };
    directionsService.route(request, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        }
        else
        {
            $('#message').empty();
            $('#message').append('Unfortunately, displaying of route to restaurant was not possible by the following reason: ' + ' ' + status);
            $('.error').show();
            $('html, body').animate({scrollTop:0}, 'slow');
        }
    });
}


// Convert string to coordinates and set custom marker on map
function geocoding(address)
{
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK)
        {
            map.setCenter(results[0].geometry.location);

            if (current_location != null)
            {
                current_location.setMap(null);
            }
            else
            {
                current_location = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    title:'You are here',
                    icon:icon1,
                    draggable:false,
                    visible:false
                });

                var listener = google.maps.event.addListener(map, "idle", function() {
                    current_location.setVisible(true);
                    google.maps.event.removeListener(listener);
                });

                current_location.setDraggable(true);
                // Dynamic route calculation
                google.maps.event.addListener(current_location, 'dragend', function() {
                    if ((current_destination != null) &&  (current_mode != null))
                    {
                        calc_route(current_location.position, current_destination, current_mode);
                        var latitude = current_location.position.lat();
                        var longtitude = current_location.position.lng();
                    }
                });
                // Removing current marker and route on dowble click
                google.maps.event.addListener(current_location, 'dblclick', function() {
                    remove_marker();
                });

                // First route calculation, after entering location
                google.maps.event.addListener(current_location, 'visible_changed', function() {
                    calc_route(current_location.position, current_destination, current_mode);
                });
            }
        }
        else
        {
            $('#message').empty();
            $('#message').append('Geocode was not successful for the following reason: ' + ' ' + status);
            $('.error').show();
            $('html, body').animate({scrollTop:0}, 'slow');
        }
    });
}



// Deletion marker & binded route
function remove_marker()
{
    if (current_location != null)
    {
        current_location.setMap(null);
        current_location = null;
    }
    if(directionsDisplay)
    {
        directionsDisplay.setMap(null);
    }
}



/* -------------------
 Controls
 ----------------------*/


// Showing form to enter location of customer
$('.m_window').click(function(){
    $('.modal').show();
    $('html, body').animate({scrollTop:0}, 'slow');
    return false;
});
// Form closure
$('.close-modal').click(function() {
    $('.modal').fadeOut(200);
});

// Showing form to enter location of customer
$('.m_window').click(function(){
    $('.modal').show();
    $('html, body').animate({scrollTop:0}, 'slow');
    return false;
});
// Form closure
$('.close-modal').click(function() {
    $('.modal').fadeOut(200);
});

function show_list(){
    $('.map-big-wrp__rest').removeClass('opened');
    $('.footer__rest').removeClass('opened');
    $('.switcher-btn__map').removeClass('active');
    $('.switcher-btn__list').addClass('active');
    $('.content-list').show();
}

function show_map(){
    $('.map-big-wrp__rest').addClass('opened');
    $('.footer__rest').addClass('opened');
    $('.content-list').hide();
    $('.switcher-btn__map').addClass('active');
    $('.switcher-btn__list').removeClass('active');
}
$('#map-toggle').click(function(){
    if($('#map-toggle').prop("checked")){
        show_list();
    } else {
        show_map();
    }
});

$('.switcher-btn__map').click(function(){
    $('#map-toggle').removeAttr("checked");
    show_map();
});

$('.switcher-btn__list').click(function(){
    $('#map-toggle').prop("checked", "checked");
    show_list();
});


$('.drive_here').on('click', function () {
    $('.map-container').show('fast');
    $('.main-content').hide('fast');
    if(typeof current_location != 'undefined'){
        var id = $(this).data('id');
        var restaurant = $.grep(restaurants, function(e){ return e.id == id});
        // Create destination for drawing route
        var current_destination = new google.maps.LatLng(restaurant[0].lat, restaurant[0].lon);
        calc_route(current_location.position, current_destination, driving_mode);
    } else {
        $('.form').show();
        $('html, body').animate({scrollTop:0}, 'slow');
    }
});

$('.show-me').on('click', function(){
    if ($(this).data('value') == 0){
        $(this).addClass('current');
        $(this).data('value', 1);
        if (current_location != null)
        {
            map.setCenter(current_location.position);
        }
    } else {
        $(this).data('value',0);
        $(this).removeClass('current');
        place_markers(restaurants_filter(restaurants));
    }
});


$('.menu-toggle').on('click', function () {
    if ($(this).data('state') == 0) {
        $(this).data('state',1);
        $(this).addClass('opened');
        $('.modal-menu').show();
        $('.map-container').hide();
        $('.primary').hide();
        $('.bottom-bar').hide();
        $('.main-content').hide();

    } else {
        $(this).data('state',0);
        $(this).removeClass('opened');
        $('.modal-menu').hide();
        $('.primary').show();
        $('.map-container').show();
        $('.bottom-bar').show();
    }
});


$('.show-restaurant-info').on('click', function () {
    var block =$(this).parent('.restaurant-info--b');
    if (block.hasClass('opened')){
        block.removeClass('opened');
        block.find('.restaurant-info__inner').hide();
    } else {
        block.addClass('opened');
        block.find('.restaurant-info__inner').show();
    }
});


// Google maps functionality
// Set markers of restaurants on map
function place_markers(locations, id)
{
    // Clean directions
    if (directionsDisplay)
    {
        directionsDisplay.setMap(null);
    }

    if (id != undefined)
    {
        var current_restaurant = $.grep(restaurants, function(e){ return e.id == id});
        current_restaurant_boundscenter = new google.maps.LatLng(current_restaurant[0].lat,current_restaurant[0].lon);
    }

    if (locations.length === 0)
    {
        var boundscenter = new google.maps.LatLng(55.751666,37.617777);
        var boundpoints = [];
    }
    else if (current_location != null)
    {
        if (id != undefined) {
            var boundscenter = current_restaurant_boundscenter;
        } else {
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(current_location.getPosition());
            bounds.extend(new google.maps.LatLng(locations[0].lat,locations[0].lon));
            var boundscenter = bounds.getCenter();
        }
    }
    else
    {

        if (id != undefined) {
            var boundscenter = current_restaurant_boundscenter;
        } else {
            var bounds = new google.maps.LatLngBounds();
            var boundpoints = [];
            for (var j = 0; j < locations.length; j++)
            {
                boundpoints[j] = new google.maps.LatLng(locations[j].lat,locations[j].lon);
            }

            for (var i = 0; i < boundpoints.length; i++) {
                bounds.extend(boundpoints[i]);
            }

            var boundscenter = bounds.getCenter();
        }
    }

    // Delete all previous markers
    for (i in markers)
    {
        markers[i].setMap(null);
    }
    markers = [];

    if (markerClusterer) {
        clearClusters();
    }

    // Set new boundscenter
    map.setCenter(boundscenter);

    var infowindow = null;
    var geocoder = new google.maps.Geocoder();
    var current_marker;
    var info_window_html = [];

    for (var i = 0; i < locations.length; i++) {
        var icon1 = "/assets/img/desktop/placemark.png";
        var icon2 = "/assets/img/desktop/placemark-red.png";
        var place = locations[i];
        var lat = place.lat;
        var lang = place.lon;
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lang),
            title:place.address,
            icon: icon1,
            shadow: new google.maps.MarkerImage('/assets/img/desktop/placemark-shadow.png',
                new google.maps.Size(52, 28),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 28)
            ),
            map:map
        });

        markers.push(marker);

        var infoWindow = new google.maps.InfoWindow();

        if (typeof place.subway_stations !== "undefined")
        {
            var color = place.subway_stations[0].color;
        }

        info_window_html = '<div class="restaurant-infowindow">';

        if (place.opening_soon != '0') {
            info_window_html += '<h4>Opening soon!</h4><br>';
        }

        info_window_html += '<h4>' + place.name + '</h4>';
        if (place.distance_human != undefined) {
            info_window_html += '<p>' + place.distance_human + ' от вас<br/>';
        }
        info_window_html += '<p>City: ' + place.city_name + '</p>';

        if (place.subway_stations !== undefined)
        {
            info_window_html += 'Subway: ' +place.subway_stations[0].name + '<br/>'; // metro
        }
        info_window_html += place.address + '</p>';
        info_window_html += '<p class="highlight">' + place.start_time + ' &mdash; '+ place.finish_time + '</p>'
        info_window_html += '<p class="highlight">' + 'phone: ' + place.phone + '</p>'
        if ((place.ext_phone != null) && (place.ext_phone != ''))
        {
            info_window_html += '(' + 'ext. ' + place.ext_phone + ')';
        }
        info_window_html += '<ul class="ui-amenities">';
        if(place.car_distribution != '0'){info_window_html += '<li><span class="i-route-02">WiFi</span></li> '; }
        if(place.wifi != '0'){info_window_html += '<li><span class="i-wifi-02">WiFi</span></li> '; }
        if(place.takeaway != '0'){info_window_html += '<li><span class="i-takeaway-02">Takeaway</span></li> '; }
        // if(place.excursion != '0'){info_window_html += '<li><span class="i-excursion-02">Tour</span></li> '; }
        if(place.breakfast != '0'){info_window_html += '<li><span class="i-breakfast-02">Breakfast</span></li> '; }
        if(place.round_the_clock != '0'){info_window_html += '<li><span class="i-schedule-02">Breakfast</span></li> '; }
        if(place.promo != '0'){info_window_html += '<li><span class="i-delivery-02">Breakfast</span></li> '; }
        info_window_html += '</ul>';
        info_window_html += '<a href="#" class="btn-light draw-route">Show route</a>';
        if(place.takeaway != '0') {
            info_window_html += '<a href="http://www.kfc.ru/app" class="btn-light">  Предварительный <br>заказ  </a>';
        }

        marker.html_content = info_window_html;
        marker.restaurant_id = place.id;
        marker.address = place.address;
        marker.restaurant_name = place.name;
        marker.share_url = place.share_url;
        marker.lat = place.lat;
        marker.lon = place.lon;

        google.maps.event.addListener(marker, 'click', function(){
            current_marker = this;
            var content = this.html_content;
            infoWindow.setOptions({ maxWidth: '500', pixelOffset: new google.maps.Size(0, 60), zIndex:1});
            infoWindow.setContent(content);
            infoWindow.open(map, this);
            this.setVisible(false);
            var temp_center = new google.maps.LatLng(this.lat,this.lon);
            map.setCenter(temp_center);
        });

        if ((restaurant_id == place.id) && (place.id == id))
        {
            current_marker = marker;
            map.setCenter(new google.maps.LatLng(current_marker.lat,current_marker.lon));
            infoWindow.setOptions({ maxWidth: '500', pixelOffset: new google.maps.Size(0, 40), zIndex:1});
            infoWindow.setContent(current_marker.html_content);
            infoWindow.open(map, current_marker);
            current_marker.setVisible(false);
        }

        // Listing buttons in infowindow
        google.maps.event.addListener(infoWindow, 'domready', function() {
            google.maps.event.addDomListener($('.draw-route')[0], 'click', function() {
                if (current_location == null)
                {
                    var temporary_bounds = new google.maps.LatLngBounds();
                    temporary_bounds.extend(current_marker.position);
                    infoWindow.close();
                    current_marker.setVisible(true);
                    $('.form').show();
                    $('html, body').animate({scrollTop:0}, 'slow');
                    map.fitBounds(temporary_bounds);
                    zoomChangeBoundsListener =
                        google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
                            if (this.getZoom()){
                                this.setZoom(14);
                            }
                        });
                    setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);
                }
                else
                {
                    calc_route(current_location.position, current_marker.position, driving_mode)
                    infoWindow.close();
                    current_marker.setVisible(true);
                }
                current_destination = current_marker.position;
                current_mode = driving_mode;
            });
        });

        google.maps.event.addListener(infoWindow, 'closeclick', function() {
            current_marker.setVisible(true); // maps API hide call
        });

        google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
                marker.setIcon(icon2);
            }
        })(marker, i));
        google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
            return function() {
                marker.setIcon(icon1);
            }
        })(marker, i));
    }


    markerClusterer = new MarkerClusterer(map, markers, {
        gridSize: 50,
        maxZoom: 15,
        styles: [{
            url: '/assets/libs_and_plugins/marker_clusterer/images/m2.png',
            height: 55,
            width: 56,
            anchor: [17, 0],
            textColor: '#fff',
            textSize: 16
        }, {
            url: '/assets/libs_and_plugins/marker_clusterer/images/m2.png',
            height: 55,
            width: 56,
            anchor: [17, 0],
            textColor: '#fff',
            textSize: 16
        }, {
            url: '/assets/libs_and_plugins/marker_clusterer/images/m3.png',
            height: 65,
            width: 66,
            anchor: [22, 20],
            textColor: '#fff',
            textSize: 16
        }]
    });

    if (id != undefined)
    {
        zoomChangeBoundsListener =
            google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
                map.setZoom(18);
            });
        setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 1000);
    }
    else
    {
        map.fitBounds(bounds);

        if (boundpoints.length > 1)
        {
            map.fitBounds(bounds);
            zoomChangeBoundsListener =
                setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);
        }

        else
        {
            zoomChangeBoundsListener =
                google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
                    map.setZoom(14);
                });
            setTimeout(function(){google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);
        }
    }
}


// Try to get distance for every restaurant to user's position
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            var min_distance = haversine_distance(position.coords.latitude, position.coords.longitude, restaurants[0].lat, restaurants[0].lon);
            for (var i = 0; i < restaurants.length; i++) {
                var distance = haversine_distance(position.coords.latitude, position.coords.longitude, restaurants[i].lat, restaurants[i].lon);
                restaurants[i]['distance'] = parseInt(Math.round(distance));
                restaurants[i].distance_human = (distance < 1) ? '~' + Math.round(distance * 1000) + ' m' : '~' + Math.round(distance) + ' km';
                if  (parseFloat(distance) < parseFloat(min_distance))
                {
                    min_distance = distance;
                }

                $('#row-' + restaurants[i].id + '').data("distance", restaurants[i]['distance']);

                var distance_data = $('#row-' + restaurants[i].id + '').find('.distance-block p');
                distance_data.empty().append(restaurants[i].distance_human + ' from you');

            }

            // Sorting object data
            restaurants = _.sortByOrder(restaurants, 'distance', 'asc');
            // Sorting list of restaurants
            $('.restaurant-info').sort(function (a, b) {
                return $(a).data('distance') - $(b).data('distance');
            }).each(function (_, container) {
                $(container).parent().append(container);
            });

            // Create user marker
            current_location = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude) ,
                title:'You are here',
                icon:icon1,
                draggable:false,
                visible:true
            });

            // Try to detect subway stations. We have sorted array of restaurants so first array item is a nearest restaurant to us
            // We will send city_id and got subway stations list
            // and generate a dropdown
            data_filter(restaurants);

            if (restaurant_id != ''){
                place_markers(restaurants_filter(restaurants), restaurant_id);
            } else {
                place_markers(restaurants_filter(restaurants));
            }

        },
        // Next function is the error callback
        function (error)
        {
            if (restaurant_id != ''){
                place_markers(restaurants_filter(restaurants), restaurant_id);
            } else {
                place_markers(restaurants_filter(restaurants));
            }
        }
    );
}
else
{
    if (restaurant_id != ''){
        place_markers(restaurants_filter(restaurants), restaurant_id);
    } else {
        place_markers(restaurants_filter(restaurants));
    }
}