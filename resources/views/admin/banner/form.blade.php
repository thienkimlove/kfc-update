@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Banners</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($banner))
            <h2>Edit</h2>
            {!! Form::model($banner, [
                'method' => 'PATCH',
                'route' => ['admin.banners.update', $banner->id],
                'files' => true
             ]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($banner = new App\Banner, ['route' => ['admin.banners.store'], 'files' => true]) !!}
            @endif

            <div class="form-group">
                {!! Form::label('url', 'URL') !!}
                {!! Form::text('url', null, ['class' => 'form-control']) !!}
            </div>

                <div class="form-group">
                    {!! Form::label('position', 'Position') !!}
                    {!! Form::text('position', null, ['class' => 'form-control']) !!}
                </div>

            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                @if ($banner->image)
                    <img src="{{url('img/cache/120x120/' . $banner->image)}}" />
                    <hr>
                @endif
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>

                <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
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