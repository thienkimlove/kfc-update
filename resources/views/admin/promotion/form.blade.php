@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Promotions</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($promotion))
            <h2>Edit</h2>
            {!! Form::model($promotion, [
                'method' => 'PATCH',
                'route' => ['admin.promotions.update', $promotion->id],
                'files' => true
             ]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($promotion = new App\Promotion, ['route' => ['admin.promotions.store'], 'files' => true]) !!}
            @endif


            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('title_'.$lang, 'Title '.$lang) !!}
                    {!! Form::text('title_'.$lang, $promotion->translateOrNew($lang)->title, ['class' => 'form-control']) !!}
                </div>
            @endforeach


            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('desc_'.$lang, 'Short Description '.$lang) !!}
                    {!! Form::textarea('desc_'.$lang, $promotion->translateOrNew($lang)->desc, ['class' => 'form-control']) !!}
                </div>
            @endforeach

            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('content_'.$lang, 'Content '.$lang) !!}
                    {!! Form::textarea('content_'.$lang, $promotion->translateOrNew($lang)->content, ['class' => 'form-control ckeditor']) !!}
                </div>
            @endforeach

            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                @if ($promotion->image)
                    <img src="{{url('img/cache/120x120/' . $promotion->image)}}" />
                    <hr>
                @endif
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>



            <div class="form-group">
                {!! Form::label('status', 'Publish') !!}
                {!! Form::checkbox('status', null, null) !!}
            </div>



            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            @include('admin.list')

        </div>
    </div>

@endsection