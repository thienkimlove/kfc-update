<li>
    <a class="{{ (isset($page) && $page == 'index') ? 'active' : '' }}" href="#" title="">Menu</a>
    <ul>
        @foreach ($headerCatalogs as $headerCatalog)
            <li>
                <a href="{{url('catalog', \App\Custom::slug($headerCatalog->name).'-'.$headerCatalog->id)}}" title="">{{$headerCatalog->name}}</a>
            </li>
        @endforeach
    </ul>
</li>
<li>
    <a class="{{ (isset($page) && $page == 'restaurant') ? 'active' : '' }}" href="{{url('restaurant')}}" title="">{{trans('frontend.menu_restaurant')}}</a>
</li>

@foreach ($headerCategories as $headerCategory)
    <li>
        <a class="{{ (isset($page) && $page == $headerCategory->name) ? 'active' : '' }}" href="{{url('category', \App\Custom::slug($headerCategory->name).'-'.$headerCategory->id)}}" title="{{$headerCategory->name}}">{{$headerCategory->name}}</a>
        @if ($headerCategory->subCategories->count() > 0)
            <ul>
                @foreach ($headerCategory->subCategories as $subCategory)
                    <li>
                        <a class="{{ (isset($page) && $page == $subCategory->name) ? 'active' : '' }}" href="{{url('category', \App\Custom::slug($subCategory->name).'-'.$subCategory->id)}}" title="{{$subCategory->name}}">{{$subCategory->name}}</a>
                        @if ($subCategory->subCategories->count() > 0)
                            <ul class="sub-menu">
                                @foreach ($subCategory->subCategories as $sub2ndCategory)
                                    <li>
                                        <a class="{{ (isset($page) && $page == $sub2ndCategory->name) ? 'active' : '' }}" href="{{url('category', \App\Custom::slug($sub2ndCategory->name).'-'.$sub2ndCategory->id)}}" title="{{$sub2ndCategory->name}}">{{$sub2ndCategory->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach

<li>
    <a class="{{ (isset($page) && $page == 'promotion') ? 'active' : '' }}" href="{{url('promotion')}}" title="">{{trans('frontend.menu_promo')}}</a>
</li>
<li>
    <a href="{{url('/')}}" title=""><img src="{{url('frontend/images/menu_play_btn.png')}}" alt=""></a>
</li>