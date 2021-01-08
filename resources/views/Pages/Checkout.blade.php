
@extends('Layout')
@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if(count(session()->get('cart_items'))==0)
                    <h1>No product to order - <a href="/">Shop now</a></h1>
                @else
                <div class="col-md-7">
                    <!-- Shipping Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Shipping address</h3>
                            @if(session()->has('user'))
                                <p>We are using your account's information</p>
                                <n>Fill the form if you want to change</n>
                            @endif
                        </div>
                        <form>
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            @csrf
                            <div class="form-group">
                                <input class="input" type="text" id="oname" name="name" placeholder="Full Name" @if(session()->has('user'))value="{{$user->name}}"@endif>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" id="oemail" placeholder="Email" @if(session()->has('user'))value="{{$user->email}}"@endif>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="address" id="oaddress" placeholder="Address" @if(session()->has('user'))value="{{$user->address}}"@endif>
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="phone" id="ophone" placeholder="Phone number" @if(session()->has('user'))value="{{$user->phone}}"@endif>
                            </div>
                            @if(!session()->has('user'))
                            <div class="form-group">
                                <div class="input-checkbox">
                                    <label for="create-account">
                                        <a href="/register">
                                        <span></span>
                                        Create Account?
                                        </a>
                                    </label>
                                </div>
                            </div>
                            @endif
                        </form>
                        <button id="order_submit" onclick="submitOrder()" class="primary-btn order-submit">Place Order</button>
                    </div>
                    <!-- /Shipping Details -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            @foreach(session()->get('cart_items') as $item)
                                <div class="order-col">
                                    <div>{{$item['amount']}}x {{$item['name']}}</div>
                                <div>${{$item['price']*$item['amount']}}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total">${{session()->get('totalPrices')}}</strong></div>
                        </div>
                    </div>
                    <div class="input-checkbox">
                        <input type="checkbox" id="terms">
                        <label for="terms">
                            <span></span>
                            I've read and accept the <a href="#">terms & conditions</a>
                        </label>
                    </div>
                </div>
                <!-- /Order Details -->
                @endif
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

@stop
@push('scripts')
    <script>
        function submitOrder() {
            $.ajax({
                type: 'post',
                url: '/orders',
                data: {
                    'name': $("#oname").val(),
                    'address': $("#oaddress").val(),
                    'phone': $("#ophone").val(),
                    'email': $("#oemail").val(),
                },
                success: function (data){
                    alert('Your order is submitted. Thank you');
                    location.replace('/')
                },
                error: function (data){
                    let errors = data.responseJSON.errors;
                    showError(errors);
                }
            })
        }
        function showError(msg){
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                let id = 'o' + key
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                $('#'+id).css('border-color', 'red');
            });
        }
    </script>
@endpush
