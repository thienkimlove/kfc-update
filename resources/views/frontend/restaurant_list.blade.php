@extends('frontend')

@section('content')

    <section class="section fix">
        <div class="layout-home">
            <div class="col-left">
                <div class="box-article">
                    @foreach ($restaurants as $restaurant)
                        <article class="item cf">
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
                                    <a href="{{url('restaurant?q='.\App\Custom::map($restaurant))}}" class="btn-detail">Show on the map</a>
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
            <div class="col-right">
                <div class="box-viewmap cf">
                    <h3 class="title">
                        Find a KFC
                    </h3>
                    <div class="search-kfc">
                        <input type="text" id="address" value="" placeholder="Enter a city, address or subway" class="txt search ui-autocomplete-input" autocomplete="off">
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
    </section>

@endsection

@section('footer_script')
    <script>
        $(function(){

            $('#search-map').click(function(){
                window.location.href = '/restaurant?q=' + encodeURIComponent($('#address').val());
            });
        });
    </script>
@endsection