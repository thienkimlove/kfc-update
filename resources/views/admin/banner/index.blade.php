@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Banner</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>URL</th>
                                <th>Image</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{$banner->id}}</td>
                                    <td>{{$banner->url}}</td>
                                    <td><img src="{{url('img/cache/120x120/' . $banner->image)}}" /></td>
                                    <td>{{$banner->position}}</td>
                                    <td>{{ ($banner->status) ? 'Yes' : 'No'  }}</td>
                                    <td>
                                        <button id-attr="{{$banner->id}}" class="btn btn-primary btn-sm edit-banner" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.banners.destroy', $banner->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$banners->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-banner" type="button">Add</button>
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
            $('.add-banner').click(function(){
                window.location.href = window.baseUrl + '/admin/banners/create';
            });
            $('.edit-banner').click(function(){
                window.location.href = window.baseUrl + '/admin/banners/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection