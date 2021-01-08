
@extends('Layout')
@section('content')
    <style>
        table {
            table-layout: fixed ;
            width: 100% ;
        }
        td {
            width: 20% ;
        }
    </style>
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if(count(session()->get('cart_items'))==0)
                    <h1>No Product in cart - <a href="/">Shop now</a></h1>
                @else
                <table class="table">
                    <thead>
                    <tr>
                        <th><h4>Product</h4></th>
                        <th><h4>Name</h4></th>
                        <th><h4>Price</h4></th>
                        <th><h4>Quantity</h4></th>
                        <th><h4>Total</h4></th>
                        <th><h4>Action</h4></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(session()->get('cart_items') as $item => $val)
                        <tr>
                            <td>
                                <img src="{{asset('assets/customer/img/' . $val['image'])}}" height="20%" alt="">
                            </td>
                            <td><a href="/products/{{$item}}">{{$val['name']}}</a></td>
                            <td>{{$val['price']}}</td>
                            <td>
                                <div class="qty-label" style="width: 60%">
                                    <div class="input-number">
                                        <input type="number" id="{{$item}}" value="{{$val['amount']}}" disabled>
                                        <span class="qty-up" onclick="updateCart({{$item}}, 1)">+</span>
                                        <span class="qty-down" onclick="updateCart({{$item}}, 0)">-</span>
                                    </div>
                                </div>
                            </td>
                            <td>${{$val['price']*$val['amount']}}</td>
                            <td><p class="mouse" onclick="deleteCart({{$item}})"><b>Delete</b></p></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><h4>SUBTOTAL:</h4></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h4>${{session()->get('totalPrices')}}</h4></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <a href="/checkout" class="primary-btn order-submit" style="margin-left: 500px">Checkout now</a>
                @endif
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    @push('scripts')
        <script>
            function checkAmount(amount, type) {

                if(type === 1){
                    amount++;
                } else if (type === 0){
                    amount--
                    if(amount <= 1){
                        amount = 1
                    }
                }
                return amount
            }
            function updateCart(id, type) {
                let amount = $('#'+id).val()
                let quantity = checkAmount(amount, type)
                $.ajax({
                    type: 'post',
                    url: '/carts/'+id,
                    data: {
                        _method: "patch",
                        'id': id,
                        'amount': quantity
                    },
                    success:function (data){
                       if(data === '0'){
                           alert('this product do not have enough ' + quantity + ' models')
                       }
                       location.reload();
                    }
                })
            }
            function deleteCart(id) {
                $.ajax({
                    type: 'post',
                    url: '/carts/'+id,
                    data:  {_method: "delete"},
                    success:function (){
                        location.reload()
                    }
                })
            }
        </script>
    @endpush
@stop
