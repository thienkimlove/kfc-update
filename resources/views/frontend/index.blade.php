@extends('frontend')

@section('content')
    <section class="fix">
        <div class="layout-home">
            <div class="col-left">
                <div class="box-slider">
                    <div class="owl-carousel" id="slide-homepage">
                        @foreach ($topBanners as $banner)
                        <div class="item">
                            <a class="thumb" href="{{$banner->url}}" title="">
                                <img src="{{url('files', $banner->image)}}"/>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div><!--//box-slider-->
            </div>
            <div class="col-right">
                <div class="search-box">
                    <span class="title">{{trans('frontend.menu_search')}}</span>
                    <input type="text" placeholder="" autocomplete="off">
                </div>
                <div class="box-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.7632620687652!2d30.272845551218296!3d60.00241926382562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4696343d7579cc91%3A0x935fad23a95a4186!2sBaykonurskaya+ul.%2C+14%2C+Sankt-Peterburg%2C+197227!5e0!3m2!1sen!2sru!4v1461628589853" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <h3 class="title">
                    {{trans('frontend.menu_carrier')}}
                </h3>
                @foreach ($bottomBanners as $banner)
                <div class="box-adv">
                    <img src="{{url('files', $banner->image)}}" alt="">
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection