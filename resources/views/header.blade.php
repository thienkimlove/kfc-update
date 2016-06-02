<header class="header">
    <div class="header-top">
        <div class="fix">
            <a class="btn-ru" href="" title="">Russian</a>
            <a class="btn-en" href="" title="">Englist</a>
            <a class="btn-vi" href="" title="">Vietnamese</a>
            <div class="clear"></div>
        </div>
    </div>
    <div class="header-mid">
        <div class="fix">
            <h1>
                <a href="" title="" class="logo">Tên game</a>
            </h1>
            <nav>
                <ul class="nav-main">
                    <li>
                        <a class="active" href="index.html" title="">Menu</a>
                        <ul>
                            @foreach ($headerCatalogs as $catalog)
                            <li>
                                <a href="{{url('catalog', \Illuminate\Support\Str::slug($catalog->translation(App::getLocale())->name))}}" title="">{{$catalog->translation(App::getLocale())->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="restaurant.html" title="">Restaurant</a>
                    </li>
                    <li>
                        <a href="#" title="">Career</a>
                        <ul>
                            <li>
                                <a href="vacancies.html">Vacancies</a>
                                <ul class="sub-menu">
                                    <li><a href="team-detail.html">Restaurant employee</a></li>
                                    <li><a href="manager-detail.html">Restaurant manager</a></li>
                                    <li><a href="office-detail.html">Restaurant's Support Center employee</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="career-in.html">Career in KFC</a>
                            </li>
                            <li>
                                <a href="work-sheet.html">Work sheet</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="">Business with KFC</a>
                        <ul>
                            <li><a href="franchising.html">Franchising</a></li>
                            <li><a href="to-owners-of-land-plots-and-premises.html">To the Owners of Land Plots and Premises</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="">About KFC</a>
                        <ul>
                            <li><a href="{{url('kfconline')}}">#KFC Online</a></li>
                            <li><a href="{{url('history')}}">History</a></li>
                            <li><a href="{{url('contacts')}}">Contacts</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('promotions')}}" title="">Promo</a>
                    </li>
                    <li>
                        <a href="" title=""><img src="{{url('frontend/images/menu_play_btn.png')}}" alt=""></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>