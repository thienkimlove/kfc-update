@extends('frontend')

@section('content')

    <section class="section fix">
        <div class="layout-home">
            <div class="box-care">
                <div class="title">{{$catalog->name}}</div>
                <div class="data">
                    @foreach ($catalog->products as $product)
                      <div class="item">
                        <a href="{{url('product', \App\Custom::slug($product->title).'-'.$product->id)}}" title="">
                            <img src="{{url('img/cache/204x144', $product->image)}}" width="204" height="144" alt=""/>
                        </a>
                        <h3 class="title">
                            {{$product->title}}
                        </h3>
                        <p>
                           {{$product->desc}}
                        </p>
                    </div>
                    @endforeach
                    <div class="clear"></div>
                </div>
            </div>
            <div class="box-more cf">
                <div class="item">
                    <h3>
                        <span class="ics ics1"></span>Fresh meat
                    </h3>
                    <p>
                        We always use only fresh whole mussel chicken meat of the highest quality. That is why we choose our suppliers with great care. Only then we can be sure that our chicken is the best.
                    </p>
                </div>
                <div class="item">
                    <h3>
                        <span class="ics ics2"></span>Experienced Staff
                    </h3>
                    <p>
                        Our restaurants employ only highly qualified staff members who completed special training. Only real professionals are admitted to cook unforgettably delicious chicken dishes of our secret recipes.
                    </p>
                </div>
                <div class="item">
                    <h3>
                        <span class="ics ics3"></span>High quality
                    </h3>
                    <p>
                        Fresh whole mussel chicken meat is not the only guarantee of unique taste of your favorite dishes: tender crispy chicken pieces, spicy chicken wings, strips, sandwiches and salads. It is also the assurance that you get the dishes of the highest quality!
                    </p>
                </div>
            </div>
        </div><!--//layout-home-->
    </section>

@endsection