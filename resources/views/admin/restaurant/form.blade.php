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
                    {!! Form::label('ext_phone', 'Ext Phone') !!}
                    {!! Form::text('ext_phone', null, ['class' => 'form-control']) !!}
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
                    {!! Form::label('wifi', 'Have WiFi?') !!}
                    {!! Form::checkbox('wifi', null, null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('round_the_clock', 'Round The Clock') !!}
                    {!! Form::checkbox('round_the_clock', null, null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('car_distribution', 'Car Distribution') !!}
                    {!! Form::checkbox('car_distribution', null, null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('corporative', 'Corporative') !!}
                    {!! Form::checkbox('corporative', null, null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('degustation', 'Degustation') !!}
                    {!! Form::checkbox('degustation', null, null) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('count_people_in_degustation', 'Number People In Degustation') !!}
                    {!! Form::text('count_people_in_degustation', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('excursion', 'Excursion') !!}
                    {!! Form::checkbox('excursion', null, null) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('count_people_in_excursion', 'Number People In Excursion') !!}
                    {!! Form::text('count_people_in_excursion', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('takeaway', 'TakeAway') !!}
                    {!! Form::checkbox('takeaway', null, null) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('breakfast', 'Have Breakfast?') !!}
                    {!! Form::checkbox('breakfast', null, null) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('breakfast_time', 'Breakfast Time') !!}
                    {!! Form::text('breakfast_time', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('promo', 'Have Promotions?') !!}
                    {!! Form::checkbox('promo', null, null) !!}
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