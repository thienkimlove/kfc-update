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
                    <span class="title">Your KFC</span>
                    <input type="text" placeholder="" autocomplete="off">
                </div>
                <div class="box-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0521015084205!2d105.78402085075172!3d21.030601193021933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4c76b12a3b%3A0x9a311c833456d5f0!2zRHV5IFTDom4sIEThu4tjaCBW4buNbmcsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1463038745076" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <h3 class="title">
                    Career
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