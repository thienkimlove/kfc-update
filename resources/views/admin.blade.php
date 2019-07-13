<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="_token" content="{!! csrf_token() !!}"/>

    <title>Admin</title>

    <!-- Custom Fonts -->
    <link href="{{ url('/css/admin.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('/css/select2.min.css')}}" rel="stylesheet" />


</head>

<body>

<div id="wrapper">

    @include('admin.nav')

    <div id="page-wrapper">
        @include('flash::message')
        @include('admin.lang')
        @yield('content')
    </div>


</div>
<script>
    var Config = {};
    window.baseUrl = '{{url('/')}}';
</script>

<script src="{{url('/js/admin.js')}}"></script>
<script src="{{url('/bower_components/ckeditor/ckeditor.js')}}"></script>
<script src="{{url('/js/select2.min.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    $(function(){
        $('#set-language > button').click(function(e){
            e.preventDefault();
            $.post('/admin/lang', {'lang' : $(this).attr('id').replace('set', '') }, function(data){
                console.log(data);
                window.location.reload();
            });
        });
    });
</script>
@yield('footer')
</body>

</html>
