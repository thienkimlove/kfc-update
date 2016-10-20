<!DOCTYPE html>
<html lang="vi">
<head>
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
    <link type="image/x-icon" href="{{url('frontend/images/favicon.ico')}}" rel="shortcut icon"/>
    <link href="https://plus.google.com/107515763736347546999" rel="publisher"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700italic,800italic,700,800&amp;subset=latin,vietnamese" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{url('frontend/css/kfc.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{url('frontend/css/libs/jquery-ui.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{url('frontend/css/colorbox.css')}}" type="text/css"/>
    <meta content='KFC' name='generator'/>
    <title>{{$meta_title}}</title>

    <meta property="og:title" content="{{$meta_title}}">
    <meta property="og:description" content="{{$meta_desc}}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$meta_url}}">
    <meta property="og:image" content="{{$meta_image}}">
    <meta property="og:site_name" content="Thông huyết">

    <meta name="twitter:card" content="Card">
    <meta name="twitter:url" content="{{$meta_url}}">
    <meta name="twitter:title" content="{{$meta_title}}">
    <meta name="twitter:description" content="{{$meta_desc}}">
    <meta name="twitter:image" content="{{$meta_image}}">

    <meta itemprop="name" content="{{$meta_title}}">
    <meta itemprop="description" content="{{$meta_desc}}">
    <meta itemprop="image" content="{{$meta_image}}">

    <meta name="ABSTRACT" content="{{$meta_desc}}"/>
    <meta http-equiv="REFRESH" content="1200"/>
    <meta name="REVISIT-AFTER" content="1 DAYS"/>
    <meta name="DESCRIPTION" content="{{$meta_desc}}"/>
    <meta name="KEYWORDS" content="{{$meta_keywords}}"/>
    <meta name="ROBOTS" content="index,follow"/>
    <meta name="AUTHOR" content="Thông huyết"/>
    <meta name="RESOURCE-TYPE" content="DOCUMENT"/>
    <meta name="DISTRIBUTION" content="GLOBAL"/>
    <meta name="COPYRIGHT" content="Copyright 2013 by Goethe"/>
    <meta name="Googlebot" content="index,follow,archive" />
    <meta name="RATING" content="GENERAL"/>
    <!--[if lte IE 8]>
    <script src="{{url('frontend/js/html5.js')}}" type="text/javascript"></script>
    <![endif]-->
    <!--[if lte IE 7]>
    <link rel="stylesheet" href="{{url('frontend/css/ie.css')}}" type="text/css"/>
    <![endif]-->

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
</head>
<body class="{{ (isset($page) && $page == 'restaurant') ? 'restaurant' : 'home'}}">
@if (isset($page) && $page == 'restaurant')
    <div id="googlemaps"></div>
@endif
<div class="wrapper" id="wrapper">
    @include('frontend.header')
    <!-- //layoutHome -->
    @yield('content')

    @include('frontend.footer')

    <div class="overlay" id="overlay"></div>
    <div class="menu-left" id="menu-left">
        <div class="inner">
            <a href="javascript:void(0)" title="Menu" class="btn-menu" id="btn-menu">Menu</a>
            <div class="search">
                <div class="search-in">
                    <form>
                        <input type="text" name="keyword" class="txt" placeholder="Từ khóa tìm kiếm"/>
                        <input type="submit" name="submit" class="btn-find" value=""/>
                    </form>
                </div>
            </div>
            <nav>
                <ul class="nav-mobile">
                   @include('frontend.menu')
                </ul>
            </nav>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{url('frontend/js/libs/jquery.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/lodash.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/libs/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/jquery.colorbox-min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/common.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/libs/js-marker-clusterer/src/markerclusterer.js')}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    (function($){
        $('#set-language > a').click(function(e){
            e.preventDefault();
            $.post('/admin/lang', {'lang' : $(this).attr('id').replace('set', '') }, function(data){
                console.log(data);
                window.location.reload();
            });
        });
    })(jQuery);
</script>
@yield('footer_script')
</body>
</html>