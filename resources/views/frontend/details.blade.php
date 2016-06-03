@extends('frontend')

@section('content')

    <section class="section fix">
        <div class="layout-home">
             {!! $category->content !!}
        </div><!--//layout-home-->
    </section><!--//section-->

@endsection