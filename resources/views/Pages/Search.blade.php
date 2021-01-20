

@extends('Layout')
@section('content')

    <!-- SECTION -->
    <div class="section" id="pros">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">Categories</h3>
                        <div class="checkbox-filter">
                            @foreach($categories as $cate)
                                <div>
                                    <label for="category-{{$cate->id}}">
                                        <span></span>
                                        <a href="/products?cate_id={{$cate->id}}"><p id="{{$cate->id}}">{{$cate->name}}</p></a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /aside Widget -->

                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">Price</h3>
                        <div class="price-filter filterID">
                            <div id="price-slider"></div>
                            <div class="input-number price-min">
                                <input id="price-min" type="number" class="price">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                            <span>-</span>
                            <div class="input-number price-max">
                                <input id="price-max" type="number" class="price">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                        </div>
                    </div>
                    <!-- /aside Widget -->

                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">Top selling</h3>
                        @foreach($top_products as $top)
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="{{asset('assets/customer/img/' . $top->image)}}" alt="">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">{{$top->category->name}}</p>
                                    <h3 class="product-name"><a href="/products/{{$top->id}}">{{$top->name}}</a></h3>
                                    <h4 class="product-price">${{$top->price}}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- /aside Widget -->
                </div>
                <!-- /ASIDE -->

                <!-- STORE -->

                <div id="store" class="col-md-9">
                    <!-- store top filter -->
                    <div class="store-filter clearfix">
                        @if($key !== null)
                            <h4><p>{{$total}} results found for: "{{$key}}"</p></h4>
                        <div class="store-sort">
                            <label>
                                Sort By Price:
                                <select class="input-select sortChange" id="sortID">
                                    <option value="asc">low to high</option>
                                    <option value="desc">high to low</option>
                                </select>
                            </label>

                            <label>
                                Show:
                                <select class="input-select changeID" id="limitID">
                                    <option value="15" id="1">15</option>
                                    <option value="20" id="2">20</option>
                                    <option value="30" id="3">30</option>
                                </select>
                            </label>
                        </div>
                        <ul class="store-grid">
                            <li class="active"><i class="fa fa-th"></i></li>
                            <li><a href="#"><i class="fa fa-th-list"></i></a></li>
                        </ul>
                    </div>
                    <!-- /store top filter -->

                    <!-- store products -->
                    <div id="proID">
                        @include('Components.SearchProductList')
                    </div>
                    @else
                        <h1>Nothing found</h1>
                        <h3>Back to <a href="/">Home Page</a></h3>
                    @endif
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@stop
@push('scripts')
    <script>
        let key= params.get('q');
        let limit= 15
        let current_page = 1
        let minPrice
        let maxPrice
        let sort = 'asc'
        $(".price").keyup(function (){
            minPrice= $("#price-min").val();
            maxPrice = $("#price-max").val();
            current_page = 1
            filter();
        });
        $(".sortChange").change(function (){
            sort = $("#sortID").val();
            current_page = 1
            filter();
        });
        $(".changeID").change(function (){
            limit = $("#limitID").val();
            current_page = 1
            filter();
        });
        $(".filterID").click(function (){
            minPrice= $("#price-min").val();
            maxPrice = $("#price-max").val();
            current_page = 1
            filter();
        })
    </script>
@endpush
