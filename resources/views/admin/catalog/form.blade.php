@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Catalog</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($catalog))
            <h2>Edit</h2>
            {!! Form::model($catalog, ['method' => 'PATCH', 'route' => ['admin.catalogs.update', $catalog->id]]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($catalog = new App\Catalog, ['route' => ['admin.catalogs.store']]) !!}
            @endif

            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('name_'.$lang, 'Name '.$lang) !!}
                    {!! Form::text('name_'.$lang, $catalog->translateOrNew($lang)->name, ['class' => 'form-control']) !!}
                </div>
            @endforeach

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