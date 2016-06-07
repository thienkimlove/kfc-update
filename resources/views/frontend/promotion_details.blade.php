@extends('frontend')

@section('content')
    <section class="section fix">
        <div class="layout-home">
            <div class="box-care">
                {!! $promotion->content !!}
            </div>
        </div><!--//layout-home-->
    </section>
@endsection