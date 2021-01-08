
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
                    @if(count($orders)==0)
                        <h1>No Product in your wishlist - <a href="/">Show now</a></h1>
                    @else
                        <tr>
                            <th><h4>Order</h4></th>
                            <th><h4>Created_date</h4></th>
                            <th><h4>Order Status</h4></th>
                            <th><h4>Payment Status</h4></th>
                            <th><h4>Shipment Status</h4></th>
                            <th><h4>Action</h4></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->code}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->orderStatus->name}}</td>
                            <td>
                                @if($order->payment_status !== null)
                                    {{$order->paymentStatus->name}}
                                @endif
                            </td>
                            <td>
                                @if($order->shipping_status !== null)
                                    {{$order->shippingStatus->name}}
                                @endif
                            </td>
                            <td>
                                <a href="/orders/{{$order->id}}"><b>Detail</b></a>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@stop
