@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Promotions</h1>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="input-group custom-search-form">
                        {!! Form::open(['method' => 'GET', 'route' =>  ['admin.promotions.index'] ]) !!}
                        <span class="input-group-btn">
                            <input type="text" value="{{$searchPromotion}}" name="q" class="form-control" placeholder="Search promotion..">

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
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($promotions as $promotion)
                                <tr>
                                    <td>{{$promotion->id}}</td>
                                    <td>{{$promotion->title }}</td>
                                    <td>{!! str_limit($promotion->desc, 200) !!}</td>
                                    <td><img src="{{url('img/cache/120x120/' . $promotion->image)}}" /></td>
                                    <td>{{ ($promotion->status) ? 'Yes' : 'No'  }}</td>
                                    <td>
                                        <button id-attr="{{$promotion->id}}" class="btn btn-primary btn-sm edit-post" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.promotions.destroy', $promotion->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$promotions->render()!!}</div>
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
                window.location.href = window.baseUrl + '/admin/promotions/create';
            });
            $('.edit-post').click(function(){
                window.location.href = window.baseUrl + '/admin/promotions/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection