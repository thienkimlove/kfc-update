@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">
            <div class="box-care">
                {!! $post->content !!}
            </div>
        </div><!--//layout-home-->
    </section>
@endsection