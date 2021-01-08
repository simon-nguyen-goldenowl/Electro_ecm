

@extends('Layout')
@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if(count($details)==0)
                    <h1>No product to order - <a href="/">Shop now</a></h1>
                @else
                    <div class="col-md-7">
                        <!-- Product Table -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th><h4>Product</h4></th>
                                <th><h4>Name</h4></th>
                                <th><h4>Price</h4></th>
                                <th><h4>Quantity</h4></th>
                                <th><h4>Total</h4></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td>
                                        <img src="{{asset('assets/customer/img/' . $detail->product->image)}}" height="20%" alt="">
                                    </td>
                                    <td><a href="/products/{{$detail->product->id}}">{{$detail->product->name}}</a></td>
                                    <td>{{$detail->price}}</td>
                                    <td>{{$detail->amount}}</td>
                                    <td>${{$detail->price*$detail->amount}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><h4>SUBTOTAL:</h4></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><h4>${{$total}}</h4></td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /Product table -->
                    </div>
                    <!-- Order Details -->
                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Order Information</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-products">
                                <div class="order-col">
                                    <div><b>Name:</b></div>
                                    <div>{{$order->name}}</div>
                                </div>
                                <div class="order-col">
                                    <div><b>Address:</b></div>
                                    <div>{{$order->address}}</div>
                                </div>
                                <div class="order-col">
                                    <div><b>Phone:</b></div>
                                    <div>{{$order->phone}}</div>
                                </div>
                                <div class="order-col">
                                    <div><b>Email:</b></div>
                                    <div>{{$order->email}}</div>
                                </div>
                            </div>
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

    </script>
@endpush
