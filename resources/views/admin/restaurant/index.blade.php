@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Restaurants</h1>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="input-group custom-search-form">
                        {!! Form::open(['method' => 'GET', 'route' =>  ['admin.restaurants.index'] ]) !!}
                        <span class="input-group-btn">
                            <input type="text" value="{{$searchRestaurant}}" name="q" class="form-control" placeholder="Search restaurant..">

                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>

                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Desc</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Postal Code</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Open-Close</th>
                                <th>Lat</th>
                                <th>Lon</th>
                                <th>Wifi</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($restaurants as $restaurant)
                                <tr>
                                    <td>{{$restaurant->id}}</td>
                                    <td>{{$restaurant->title }}</td>
                                    <td>{!! str_limit($restaurant->desc, 200) !!}</td>
                                    <td>{{$restaurant->address }}</td>
                                    <td>{{$restaurant->city }}</td>
                                    <td>{{$restaurant->postal_code }}</td>
                                    <td>{{$restaurant->country }}</td>
                                    <td>{{$restaurant->phone }}</td>
                                    <td>{{$restaurant->open}} : {{$restaurant->close}}</td>
                                    <td>{{$restaurant->lat }}</td>
                                    <td>{{$restaurant->lon }}</td>
                                    <td>{{ ($restaurant->wifi) ? 'Yes' : 'No'  }}</td>
                                    <td><img src="{{url('img/cache/120x120/' . $restaurant->image)}}" /></td>
                                    <td>{{ ($restaurant->status) ? 'Yes' : 'No'  }}</td>
                                    <td>
                                        <button id-attr="{{$restaurant->id}}" class="btn btn-primary btn-sm edit-post" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.restaurants.destroy', $restaurant->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$restaurants->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-post" type="button">Add</button>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
@endsection
@section('footer')
    <script>
        $(function(){
            $('.add-post').click(function(){
                window.location.href = window.baseUrl + '/admin/restaurants/create';
            });
            $('.edit-post').click(function(){
                window.location.href = window.baseUrl + '/admin/restaurants/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection