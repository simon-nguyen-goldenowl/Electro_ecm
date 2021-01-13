
<!-- HEADER -->
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li>
                    @if(session()->has('user'))
                        <a href="/profile"><i class="fa fa-user-o"></i> My Account</a>
                    @else
                        <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-user-o"></i> login</a>
                    @endif
                </li>
                @if(session()->has('user'))
                    <li>
                        <a href="/orders"><i class="fa fa-first-order"></i> My Orders</a>
                    </li>
                    <li>
                        <p onclick="getLogout()" style="cursor: pointer; color: #ffffff "><i class="fa fa-sign-out"></i> Log out</p>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="/"  class="logo">
                            <img src="{{asset('assets/customer/img/logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-4">
                    <div class="header-search">
                        <form>
                            <select class="input-select">
                                <option value="0">All categories</option>
                                <option value="1">Category 01</option>
                                <option value="1">Category 02</option>
                            </select>
                            <input class="input" placeholder="Search here">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-5 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            @if(session()->has('user'))
                            <a href="/wishlists" class="wishlist">
                                <i class="fa fa-heart-o"></i>
                                <span>My Wishlist</span>
                            </a>
                            @else
                                <a href="" class="wishlist" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-heart-o "></i>
                                <span>My Wishlist</span>
                                </a>
                            @endif
                        </div>
                        <!-- /Wishlist -->
                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>My Cart</span>
                                <div class="qty">{{session()->get('totalItems')}}</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    @foreach(array_slice(session()->get('cart_items'), 0, 4) as $item)
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="{{asset('assets/customer/img/' . $item['image'])}}" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">{{$item['name']}}</a></h3>
                                                <h4 class="product-price"><span class="qty">{{$item['amount']}}x</span>${{$item['price']}}</h4>
                                            </div>
                                            <button class="delete"><i class="fa fa-close"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cart-summary">
                                    <small>{{session()->get('totalItems')}} Item(s) selected</small>
                                    <h5>SUBTOTAL: ${{session()->get('totalPrices')}}</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="/carts">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-bell"></i>
                                <span>Notifications</span>
                                <div class="qty">{{session()->get('totalItems')}}</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    @foreach(array_slice(session()->get('cart_items'), 0, 4) as $item)
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="{{asset('assets/customer/img/' . $item['image'])}}" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">{{$item['name']}}</a></h3>
                                                <h4 class="product-price"><span class="qty">{{$item['amount']}}x</span>${{$item['price']}}</h4>
                                            </div>
                                            <button class="delete"><i class="fa fa-close"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cart-summary">
                                    <small>{{session()->get('totalItems')}} Item(s) selected</small>
                                    <h5>SUBTOTAL: ${{session()->get('totalPrices')}}</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="/carts">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
<!-- /HEADER -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="luser"placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="lpassword" placeholder="Password" required>
                    </div>
                    <a href="/password/forgot">Forgot Password ?</a>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-danger" href="/register">Sign up</a>
                    <button type="button" onclick="getLogin()" class="btn btn-primary">Sign in</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
 function getLogin() {
     $.ajax({
         type: 'post',
         url: '/login',
         data: {
             'username': $("#luser").val(),
             'password': $("#lpassword").val()
         },
         success: function(data) {
             $(".print-error-msg").find("ul").html('');
             $(".print-error-msg").css('display','block');
             if(data === '0'){
                 $(".print-error-msg").find("ul").append('<li>wrong username or password</li>');
             } else {
                 alert('login successfully');
                 location.reload();
             }
         }
     })
 }
 function getLogout(){

     if(confirm('Do you want to log out?')) {
         $.ajax({
             type: 'post',
             url: '/logout',
             data:  {_method: "delete"},
             success: function() {
                     location.reload();
             }
         })
     }
 }
</script>
