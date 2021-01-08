
@extends('Layout')
@section('content')
    <!-- SECTION -->
    <div class="section" id="detailProduct">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{session()->get('message')}}
                    </div>
                @endif
                <!-- Product main img -->
                <div class="col-md-5">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img src="{{asset('assets/customer/img/' . $detail->image)}}" alt="">
                        </div>
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{$detail->name}}</h2>
                        <div>
                            <h3 class="product-price">${{$detail->price}}</h3>
                            @if($detail->amount > 0)
                                <span class="product-available">In Stock</span>
                            @else
                                <span class="product-available">Out of Stock</span>
                            @endif
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="add-to-cart">
                            @if($detail->amount > 0)
                                <form action="/carts/{{$detail->id}}" method="post">
                                    @csrf
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>add to cart</button>
                                </form>
                            @else
                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>This product is out of stock</button>
                            @endif
                        </div>
                        <ul class="product-btns">
                            @if(session()->get('user') === null)
                                <li>
                                    <p class="mouse" href="#" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-heart-o"></i> add to wishlist</p>
                                </li>
                            @else
                                <li>
                                    <p class="mouse" onclick="addWishlist({{$detail->id}})">
                                        <i class="fa fa-heart-o"></i> add to wishlist</p>
                                </li>
                            @endif
                            <li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li>
                        </ul>
                        <ul class="product-links">
                            <li>Category:</li>
                            <li><a href="/products?cate_id={{$detail->category->id}}">{{$detail->category->name}}</a></li>
                            <li>Brand:</li>
                            <li> <b>{{$detail->brand->name}}</b></li>
                        </ul>
                        <ul class="product-links">
                            <li>Share:</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li style="color: #d10024"><b>Reviews</b></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- review tab -->
                            @include('Components.Review', ['id'=> $detail->id])
                            <!-- /review tab  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Related Products</h3>
                    </div>
                </div>

                <!-- product -->
                    @foreach($related as $rel)
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                        <div class="product-img">
                            <img src="{{asset('assets/customer/img/' . $rel->image)}}" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">{{$rel->category->name}}-{{$rel->brand->name}}</p>
                            <h3 class="product-name"><a href="/products/{{$rel->id}}">{{$rel->name}}</a></h3>
                            <h4 class="product-price">${{$rel->price}}</h4>
                            <div class="product-rating">
                            </div>
                            <div class="product-btns">
                                @if(session()->get('user') === null)
                                    <button class="add-to-wishlist" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-heart-o"></i>
                                        <span class="tooltipp" >add to wishlist</span>
                                    </button>
                                @else
                                    <button class="add-to-wishlist" onclick="addWishlist({{$rel->id}})">
                                        <i class="fa fa-heart-o"></i><span class="tooltipp" >add to wishlist</span>
                                    </button>
                                @endif
                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                        </div>
                        <div class="add-to-cart">
                            <a href="/carts/{{$rel->id}}">
                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>add to cart</button>
                            </a>
                        </div>
                    </div>
                    </div>
                    @endforeach
                <!-- /product -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->
    @stop



