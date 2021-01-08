
@extends('Layout')
@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{session()->get('message')}}
                    </div>
                @endif
                <!-- shop -->
                @foreach($categories as $cate)
                <div class="col-md-3 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{asset('assets/customer/img/shop01.png')}}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>{{$cate->name}}<br>Collection</h3>
                            <a href="/products?cate_id={{$cate->id}}" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- /shop -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- NEW PRODUCT SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                @foreach($categories as $cate)
                                    <li><a href="/products?cate_id={{$cate->id}}">{{$cate->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- product -->
                                    @foreach($new_products as $product)
                                        <div class="product">
                                        <div class="product-img">
                                            <img src="{{asset('assets/customer/img/'. $product->image)}}" alt="" height="250">
                                            <div class="product-label">
                                                <span class="sale">-30%</span>
                                                <span class="new">NEW</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">{{$product->category->name}}</p>
                                            <h3 class="product-name"><a href="/products/{{$product->id}}">{{$product->name}}</a></h3>
                                            <h4 class="product-price">${{$product->price}}</h4>
                                            <div class="product-btns">
                                                @if(session()->get('user') === null)
                                                    <button class="add-to-wishlist" data-toggle="modal" data-target="#exampleModal">
                                                        <i class="fa fa-heart-o"></i>
                                                        <span class="tooltipp" >add to wishlist</span>
                                                    </button>
                                                @else
                                                    <button class="add-to-wishlist" onclick="addWishlist({{$product->id}})">
                                                        <i class="fa fa-heart-o"></i><span class="tooltipp" >add to wishlist</span>
                                                    </button>
                                                @endif
                                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            @if($product->amount > 0)
                                                <form action="/carts/{{$product->id}}" method="post">
                                                    @csrf
                                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>add to cart</button>
                                                </form>
                                            @else
                                                <button class="add-to-cart-btn">Out of stock</button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- /product -->
                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEW PRODUCT SECTION -->

    <!-- HOT DEAL SECTION -->
    <div id="hot-deal" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="hot-deal">
                        <ul class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3>02</h3>
                                    <span>Days</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>10</h3>
                                    <span>Hours</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>34</h3>
                                    <span>Mins</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>60</h3>
                                    <span>Secs</span>
                                </div>
                            </li>
                        </ul>
                        <h2 class="text-uppercase">hot deal this week</h2>
                        <p>New Collection Up to 50% OFF</p>
                        <a class="primary-btn cta-btn" href="#">Shop now</a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOT DEAL SECTION -->

    <!-- TOP SELLING SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Top selling</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                @foreach($categories as $cate)
                                    <li><a href="/products?cate_id={{$cate->id}}">{{$cate->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab2" class="tab-pane fade in active">
                                <div class="products-slick" data-nav="#slick-nav-2">
                                    <!-- product -->
                                    @foreach($top_products as $top)
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="{{asset('assets/customer/img/' . $top->image)}}" alt="">
                                                <div class="product-label">
                                                    <span class="sale">-30%</span>
                                                    <span class="new">NEW</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">{{$top->category->name}}</p>
                                                <h3 class="product-name"><a href="/products/{{$top->id}}">{{$top->name}}</a></h3>
                                                <h4 class="product-price">${{$top->price}}</h4>
                                                <div class="product-btns">
                                                    @if(session()->get('user') === null)
                                                        <button class="add-to-wishlist" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fa fa-heart-o"></i>
                                                            <span class="tooltipp" >add to wishlist</span>
                                                        </button>
                                                    @else
                                                        <button class="add-to-wishlist" onclick="addWishlist({{$top->id}})">
                                                            <i class="fa fa-heart-o"></i><span class="tooltipp" >add to wishlist</span>
                                                        </button>
                                                    @endif
                                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                @if($top->amount > 0)
                                                    <form action="/carts/{{$top->id}}" method="post">
                                                        @csrf
                                                        <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>add to cart</button>
                                                    </form>
                                                @else
                                                    <button class="add-to-cart-btn">Out of stock</button>
                                                @endif
                                            </div>
                                        </div>
                                @endforeach
                                    <!-- /product -->
                                </div>
                                <div id="slick-nav-2" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- /Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /TOP SELLING SECTION -->
@stop

