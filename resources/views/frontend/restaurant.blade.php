@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">
            <div class="col-right">
                <div class="box-viewmap cf">
                    <h3 class="title">
                        Find a KFC
                    </h3>
                    <div class="search-kfc">
                        <input type="text" id="address" value="{{ (isset($location)) ? $location : '' }}" placeholder="Enter a city, address or subway" class="txt search ui-autocomplete-input" autocomplete="off">
                        <button id="search-map">Search</button>
                    </div>
                    <ul class="map-services-list">
                        <li class="route m-ico current">
                            <a href="">route</a>
                        </li>
                        <li class="delivery m-ico">
                            <a href="">route</a>
                        </li>
                        <li class="schedule m-ico">
                            <a href="">route</a>
                        </li>
                        <li class="breakfast m-ico">
                            <a href="">route</a>
                        </li>
                        <li class="wifi m-ico">
                            <a href="">route</a>
                        </li>
                        <li class="takeaway m-ico">
                            <a href="">route</a>
                        </li>
                        <li class="show-me m-ico">
                            <a href="">route</a>
                        </li>
                    </ul>
                    <div class="group-view">
                        <a href="{{url('restaurant-list')}}">List</a>
                        <a href="{{url('restaurant')}}">Map</a>
                    </div>
                </div>
            </div>

        </div><!--//layout-home-->
    </section><!--//section-->
@endsection

@section('footer_script')
    <script>
        $(function(){
            initialize();
            var restaurants = <?php echo $restaurants->toJson() ?>;

            displayAddress(restaurants);

            $('#search-map').click(function(){
                var address = [$('#address').val()];
                displayAddress(address);
            });
        });
    </script>
@endsection