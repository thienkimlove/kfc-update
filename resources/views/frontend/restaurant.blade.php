@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">

            <div class="col-left" id="restaurant-list">
                <div class="box-article">
                    @foreach ($restaurants as $restaurant)
                        <article class="item cf" id="row-{{$restaurant->id}}">
                            <div class="list-name">
                                <h4>
                                    {{$restaurant->title}}
                                </h4>
                            </div>
                            <div class="list-content">
                                <p>
                                    {{$restaurant->address}}<br>
                                    phone: {{$restaurant->phone}}
                                </p>
                                <time class="time" datetime="{{$restaurant->open}} — {{$restaurant->close}}">{{$restaurant->open}} — {{$restaurant->close}}</time>
                                <p>
                                    <a id="show-map-{{$restaurant->id}}" href="#" class="btn-detail show-map-detail">Show on the map</a>
                                </p>
                            </div>
                            <div class="list-icon">
                                <ul class="ui-amenities">
                                    <li><span class="i-route-02">Парковка</span></li>
                                    <li><span class="i-delivery-02">Доставка</span></li>
                                    <li><span class="i-schedule-02">График работы</span></li>
                                    <li><span class="i-breakfast-02">Завтрак</span></li>
                                    <li><span class="i-wifi-02">WiFi</span></li>
                                </ul>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="col-right" id="restaurant-map">
                <div class="box-viewmap cf">
                    <h3 class="title">
                        Find a KFC
                    </h3>
                    <div class="search-kfc">
                        <input type="text" id="address" value="{{ (isset($location)) ? $location : '' }}" placeholder="Enter a city, address or subway" class="txt search ui-autocomplete-input" autocomplete="off">
                    </div>
                    <ul class="map-services-list">
                        <li class="route m-ico current">
                            <a id="route" href="#">route</a>
                        </li>
                        <li class="delivery m-ico">
                            <a id="promo" href="#">promo</a>
                        </li>
                        <li class="schedule m-ico">
                            <a id="schedule" href="#">schedule</a>
                        </li>
                        <li class="breakfast m-ico">
                            <a id="breakfast" href="#">breakfast</a>
                        </li>
                        <li class="wifi m-ico">
                            <a id="wifi" href="#">wifi</a>
                        </li>
                        <li class="takeaway m-ico">
                            <a id="takeaway" href="#">takeaway</a>
                        </li>
                        <li class="show-me m-ico">
                            <a id="show-me" href="#">show-me</a>
                        </li>
                    </ul>
                    <!--<p class="show-all"><a href="#" id="show-all">Show all</a></p>-->
                    <div class="group-view">
                        <a id="show-list" href="#">List</a>
                        <a id="show-map" href="#">Map</a>
                    </div>
                </div>
            </div>

        </div><!--//layout-home-->
    </section><!--//section-->
@endsection

@section('footer_script')
    <script>
        $(function(){
            var restaurants = <?php echo $restaurants->toJson() ?>;
            var restaurant_id = '';
            var current_location;
            var current_destination;
            var current_mode;

            var directionsDisplay;

            var default_lat = 27.1959739;
            var default_lon = 78.02423269999997;
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
                zoom: 16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
// Directions on restaurants map

// Map creation
            var map = new google.maps.Map(document.getElementById("googlemaps"), mapOptions);
// Capital

            var icon1 = "/frontend/images/placemark-red.png";
// Filters array contains all filter names we need
// var filters = ['wifi', 'excursion', 'takeaway', 'schedule', 'breakfast', 'promo', 'route'];
            var filters = ['wifi', 'schedule', 'breakfast', 'promo', 'route', 'takeaway'];


            // Filters for restaurants list
            function data_filter(restaurants) {


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




            function set_filters_state(filter, state){
                $.each(filters, function( index, value ) {
                    if (value != filter) {
                        $('#' + value).data("value", state);
                    }
                });
            }


            function clearClusters(e) {
                markerClusterer.clearMarkers();
            }

            function where_enabled(collection, filters) {
                filters = _.pick(filters, function(value) {
                    return (value != '0')
                })

                console.log(filters);
                return _.where(collection, filters)
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

            function click_filter_button(field, object) {
                console.log($('#' + field).data('value'));
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

                var filter_restaurant = restaurants_filter(restaurants);

                if (filter_restaurant.length == 0) {
                    filter_restaurant = restaurants;
                }

                place_markers(filter_restaurant);
                remove_marker();
            }

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
                       console.log('Unfortunately, displaying of route to restaurant was not possible by the following reason: ' + ' ' + status);
                    }
                });
            }


            function place_markers(locations, id)
            {
                if (id != undefined)
                {
                    var current_restaurant = $.grep(restaurants, function(e){ return e.id == id});
                    current_restaurant_boundscenter = new google.maps.LatLng(current_restaurant[0].lat,current_restaurant[0].lon);
                }

                if (locations.length === 0)
                {
                    var boundscenter = new google.maps.LatLng(default_lat,default_lon);
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
                var current_marker;
                var info_window_html = [];

                for (var i = 0; i < locations.length; i++) {
                    var icon1 = "/frontend/images/placemark.png";
                    var icon2 = "/frontend/images/placemark-red.png";
                    var place = locations[i];
                    var lat = place.lat;
                    var lang = place.lon;
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, lang),
                        title:place.address,
                        icon: icon1,
                        shadow: new google.maps.MarkerImage('/frontend/images/placemark-shadow.png',
                                new google.maps.Size(52, 28),
                                new google.maps.Point(0,0),
                                new google.maps.Point(10, 28)
                        ),
                        map:map
                    });

                    markers.push(marker);

                    var infoWindow = new google.maps.InfoWindow();

                    info_window_html = '<div class="restaurant-infowindow">';


                    info_window_html += '<h4>' + place.title + '</h4>';

                    info_window_html += '<p>City: ' + place.city + '</p>';

                    info_window_html += place.address + '</p>';
                    info_window_html += '<p class="highlight">' + place.open + ' &mdash; '+ place.close + '</p>'
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
                    marker.restaurant_name = place.title;
                    marker.lat = place.lat;
                    marker.lon = place.lon;

                    google.maps.event.addListener(marker, 'click', function(){
                        current_marker = this;
                        var content = this.html_content;
                        console.log(content);
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
                        url: '/frontend/js/libs/js-marker-clusterer/images/m2.png',
                        height: 55,
                        width: 56,
                        anchor: [17, 0],
                        textColor: '#fff',
                        textSize: 16
                    }, {
                        url: '/frontend/js/libs/js-marker-clusterer/images/m2.png',
                        height: 55,
                        width: 56,
                        anchor: [17, 0],
                        textColor: '#fff',
                        textSize: 16
                    }, {
                        url: '/frontend/js/libs/js-marker-clusterer/images/m3.png',
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

            $('div#restaurant-list').hide();

            $.each(filters, function( index, value ) {
                $('#' + value).data("value", 0);
            });
            $('#route').data("value", 1);

            $('#show-list').click(function(){
                $('div#restaurant-list').show();
                $('div#googlemaps').hide();
            });


            $('#show-map').click(function(){
                $('div#restaurant-list').hide();
                $('div#googlemaps').show();
            });

            $('a.show-map-detail').click(function(){
                var id = $(this).attr('id').replace('show-map-', '');
                place_markers(restaurants, id);
                $('div#restaurant-list').hide();
                $('div#googlemaps').show();
            });


            $('li.m-ico').click( function(e){
                e.preventDefault();
                var a = $(this).find('a');
                click_filter_button(a[0].id, $(this));
                return false;
            });

            place_markers(restaurants);

            $('#address').keypress(function (e) {
                if (e.which == 13) {
                    var address = $(this).val();
                    if (address) {

                    }
                }
            });

        });
    </script>
@endsection