@extends('admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Catalogs</h1>
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($catalogs as $cate)
                                <tr>
                                    <td>{{$cate->id}}</td>
                                    <td><a href="{{url('admin/products/?cat='. $cate->id)}}">{{ $cate->name }}</a></td>
                                    <td>{{ ($cate->status)? 'Active' : 'Inactive'  }}</td>
                                    <td>
                                        <button id-attr="{{$cate->id}}" class="btn btn-primary btn-sm edit-cate" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.catalogs.destroy', $cate->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$catalogs->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-cate" type="button">Add</button>
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
            $('.add-cate').click(function(){
                window.location.href = window.baseUrl + '/admin/catalogs/create';
            });
            $('.edit-cate').click(function(){
                window.location.href = window.baseUrl + '/admin/catalogs/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection