@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Categories</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($category))
            <h2>Edit</h2>
            {!! Form::model($category, ['method' => 'PATCH', 'route' => ['admin.categories.update', $category->id]]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($category = new App\Category, ['route' => ['admin.categories.store']]) !!}
            @endif

            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('name_'.$lang, 'Name '.$lang) !!}
                    {!! Form::text('name_'.$lang, $category->translateOrNew($lang)->name, ['class' => 'form-control']) !!}
                </div>
            @endforeach


            <div class="form-group">
                {!! Form::label('Parent', 'Parent') !!}
                {!! Form::select('parent_id', $parents, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('display_as_post', 'Hien thi bai post trong detail cua chuyen muc') !!}
                {!! Form::text('display_as_post', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}

            @include('admin.list')

        </div>
    </div>
@endsection