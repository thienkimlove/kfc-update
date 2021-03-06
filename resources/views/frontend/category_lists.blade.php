@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">
            <div class="box-article">
                @foreach ($posts as $post)
                    @if ($post->video_url)
                        <article class="item cf">
                            <a href="{{$post->video_url}}" title="" class="thumbs-video youtube">
                                <img src="{{url('img/cache/220x130', $post->image)}}" width="220" height="130" alt=""/>
                            </a>
                            <time class="time" datetime="{{$post->created_at->toDateString()}}">{{$post->created_at->toDateString()}}</time>
                            <h3>
                                <a href="{{url('post', \App\Custom::slug($post->title).'-'.$post->id)}}" title="">
                                    {{$post->title}}
                                </a>
                            </h3>
                            <p>
                                {{$post->desc}}
                            </p>
                        </article>
                    @else
                        <article class="item cf">
                            <a href="{{url('post', \App\Custom::slug($post->title).'-'.$post->id)}}" title="">
                                <img src="{{url('img/cache/220x130', $post->image)}}" width="220" height="130" alt=""/>
                            </a>
                            <time class="time" datetime="{{$post->created_at->toDateString()}}">{{$post->created_at->toDateString()}}</time>
                            <h3>
                                <a href="{{url('post', \App\Custom::slug($post->title).'-'.$post->id)}}" title="">
                                    {{$post->title}}
                                </a>
                            </h3>
                            <p>
                                {{$post->desc}}
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
                    @endif
                @endforeach
            </div>


            <div class="box-paging">
                 @include('pagination.default', ['paginate' => $posts])
                <div class="clear"></div>
            </div>
        </div><!--//layout-home-->
    </section>
@endsection