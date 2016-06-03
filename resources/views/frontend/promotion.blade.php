@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">
            <div class="box-article">
                @foreach ($promotions as $promotion)
                <article class="item cf">
                    <a href="" title="">
                        <img src="{{url('img/cache/220x130', $promotion->image)}}" width="220" height="130" alt=""/>
                    </a>
                    <time class="time" datetime="{{$promotion->created_at->toDateString()}}">{{$promotion->created_at->toDateString()}}</time>
                    <h3>
                        <a href="#" title="">
                            {{$promotion->title}}
                        </a>
                    </h3>
                    <p>
                        {{$promotion->desc}}
                    </p>
                    <div class="soc-sharing">
                        <div class="sharing-item kfc-media">
                            <a href="#">Photo</a>
                            <span class="sharing-item-counter"><b>18</b></span>
                        </div>
                        <div class="sharing-item kfc-liked">
                            <a href="#">Like</a>
                            <span class="sharing-item-counter"><b>25</b></span>
                        </div>
                        <div class="sharing-item kfc-sharing">
                            <a href="#">Share</a>
                            <span class="sharing-item-counter"><b>123</b></span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div><!--//layout-home-->
    </section>
@endsection