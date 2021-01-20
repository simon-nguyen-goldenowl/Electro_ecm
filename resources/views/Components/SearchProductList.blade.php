
<div class="row">

    <!-- product -->
    @if(count($products) == 0)
        <div class="middle">
            <img style="text-align: center" src="{{asset('assets/customer/img/no_product.jpg')}}" alt="">
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{session()->get('message')}}
        </div>
    @endif
    @foreach($products as $product)
        <div class="col-md-4 col-xs-6">
            <div class="product" >
                <div class="product-img">
                    <img src="{{asset('assets/customer/img/' . $product->image)}}" alt="">
                    <div class="product-label">
                        <span class="sale">-30%</span>
                        <span class="new">NEW</span>
                    </div>
                </div>
                <div class="product-body">
                    <p class="product-category">{{$product->cate}} - {{$product->brand}}</p>
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
        </div>
    @endforeach
<!-- /product -->
    <div class="clearfix visible-sm visible-xs"></div>
</div>
<!-- store bottom filter -->
@include('Components.SearchPagination', ['paginate' => $paginate])
<!-- /store bottom filter -->
@push('scripts')
    <script>
        let pageNumber
        function changePage(page){
            current_page = page;
            filter()
        }
        function filter(){
            let data = {
                'min_price': minPrice,
                'max_price': maxPrice,
                'column': 'price',
                'sort': sort,
                'limit': limit,
                'page': current_page
            };
            if(key !== null) {
                data.q = key;
            }
            $.ajax({
                type: 'get',
                url: '/search-list',
                data: data,
                success:function(data){
                    $('#proID').html(data);
                    $("#page" + current_page).css('color','#D10024')
                }
            })
        }
    </script>
@endpush



