

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

                    <table class="table">
                        <thead>
                        @if(count($items)==0)
                            <h1>No Product in your wishlist - <a href="/">Shop now</a></h1>
                        @else
                        <tr>
                            <th><h4>Product</h4></th>
                            <th><h4>Name</h4></th>
                            <th><h4>Price</h4></th>
                            <th><h4>Action</h4></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <img src="{{asset('assets/customer/img/' . $item->product->image)}}" height="20%" alt="product">
                                </td>
                                <td><a href="/products/{{$item->product->id}}">{{$item->product->name}}</a></td>
                                <td>{{$item->product->price}}</td>
                                <td>
                                    <p class="mouse" style="margin: 0; display: inline;" onclick="deleteWishlist({{$item->product->id}})">
                                        <b>Delete </b>
                                    </p>|
                                    @if($item->product->amount > 0)
                                        <p class="mouse" style="margin: 0; display: inline;" onclick="addCart({{$item->product->id}})">
                                            <b>Add to cart</b>
                                        </p>
                                    @else
                                        <p style="margin: 0; display: inline;"><b>Out of stock</b></p>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                <p id="message" hidden>{{session()->get('message')}}</p>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@stop
@push('scripts')
    <script>
        notify()
        function notify() {
            let val = $("#message").text();
            if(val !== '' ){
                alert(val)
            }
        }
        function addCart(id){
            if(confirm('Add this product to your cart?')){
                $.ajax({
                    type: 'post',
                    url: '/carts/'+id,
                    success:function (){
                        location.reload()
                    }
                })
            }
        }
        function deleteWishlist(id) {
            if(confirm('Delete this product to your wishlist?')){
                $.ajax({
                    type: 'post',
                    url: '/wishlists/'+id,
                    data:  {_method: "delete"},
                    success:function (){
                        location.reload()
                    }
                })
            }
        }
    </script>
@endpush
