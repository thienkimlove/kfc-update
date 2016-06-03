@extends('admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Restaurants</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($restaurant))
            <h2>Edit</h2>
            {!! Form::model($restaurant, [
                'method' => 'PATCH',
                'route' => ['admin.restaurants.update', $restaurant->id],
                'files' => true
             ]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($restaurant = new App\Restaurant, ['route' => ['admin.restaurants.store'], 'files' => true]) !!}
            @endif


            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('title_'.$lang, 'Title '.$lang) !!}
                    {!! Form::text('title_'.$lang, $restaurant->translateOrNew($lang)->title, ['class' => 'form-control']) !!}
                </div>
            @endforeach


            <div class="form-group">
                {!! Form::label('address', 'Address') !!}
                {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('city', 'City') !!}
                {!! Form::text('city', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('postal_code', 'Postal Code') !!}
                {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('country', 'Country') !!}
                {!! Form::text('country', null, ['class' => 'form-control']) !!}
            </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('open', 'Time Open') !!}
                    {!! Form::text('open', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('close', 'Time Close') !!}
                    {!! Form::text('close', null, ['class' => 'form-control']) !!}
                </div>

            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('desc_'.$lang, 'Short Description '.$lang) !!}
                    {!! Form::textarea('desc_'.$lang, $restaurant->translateOrNew($lang)->desc, ['class' => 'form-control']) !!}
                </div>
            @endforeach

            @foreach(config('const.lang') as $lang)
                <div class="form-group">
                    {!! Form::label('content_'.$lang, 'Content '.$lang) !!}
                    {!! Form::textarea('content_'.$lang, $restaurant->translateOrNew($lang)->content, ['class' => 'form-control ckeditor']) !!}
                </div>
            @endforeach

            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                @if ($restaurant->image)
                    <img src="{{url('img/cache/120x120/' . $restaurant->image)}}" />
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