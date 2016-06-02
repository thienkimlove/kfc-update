<div class="row">
    <div class="col-lg-12">
        <div id="set-language">
            <h3>Current Language : {{ strtoupper(session()->get('language')) }}</h3>
            @foreach (config('const.lang') as $lang)
                @if ($lang != session()->get('language'))
                   <button class="btn" id="set{{$lang}}">Set Language : <b>{{strtoupper($lang)}}</b></button>
                @endif
            @endforeach
        </div>
    </div>

</div>
