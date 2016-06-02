<li>
    <a class="{{ (isset($page) && $page == 'index') ? 'active' : '' }}" href="#" title="">Menu</a>
    <ul>
        @foreach ($headerCatalogs as $headerCatalog)
            <li>
                <a href="{{url('catalog', \App\Custom::slug($headerCatalog->name))}}" title="">{{$headerCatalog->name}}</a>
            </li>
        @endforeach
    </ul>
</li>
<li>
    <a class="{{ (isset($page) && $page == 'restaurant') ? 'active' : '' }}" href="{{url('restaurant')}}" title="">{{trans('frontend.menu_restaurant')}}</a>
</li>

@foreach ($headerCategories as $headerCategory)
    <li>
        <a href="{{url('category', \App\Custom::slug($headerCategory->name))}}" title="{{$headerCategory->name}}">{{$headerCategory->name}}</a>
        @if ($headerCategory->subCategories->count() > 0)
            <ul>
                @foreach ($headerCategory->subCategories as $subCategory)
                    <li>
                        <a href="{{url('category', \App\Custom::slug($subCategory->name))}}" title="{{$subCategory->name}}">{{$subCategory->name}}</a>
                        @if ($subCategory->subCategories->count() > 0)
                            <ul class="sub-menu">
                                @foreach ($subCategory->subCategories as $sub2ndCategory)
                                    <li>
                                        <a href="{{url('category', \App\Custom::slug($sub2ndCategory->name))}}" title="{{$sub2ndCategory->name}}">{{$sub2ndCategory->name}}</a>
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
    <a href="{{url('promo')}}" title="">{{trans('frontend.menu_promo')}}</a>
</li>
<li>
    <a href="{{url('/')}}" title=""><img src="{{url('frontend/images/menu_play_btn.png')}}" alt=""></a>
</li>