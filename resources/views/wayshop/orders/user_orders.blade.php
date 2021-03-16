@extends('wayshop.layouts.master')
@section('content')

 <!-- Start Cart  -->
 <div class="cart-box-main">
    <div class="container">
        <h1 class="text-center">User Orders</h1><br><br>
        <div class="row">
            <div class="col-lg-12">
               <table class="table table-hover table-striped table-bordred" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Product</th>
                        <th>Payment Method</th>
                        <th>Grand Total</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>
                            @foreach ($order->orders as $pro)
                                <a href="{{url('/orders/'.$order->id)}}">
                                   {{$pro->product_code}} &nbsp; | &nbsp;
                                   {{$pro->product_qty}}
                                </a>  <br>
                            @endforeach
                        </td>
                        <td>{{$order->payment_method}}</td>
                        <td>{{$order->grand_total}}</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                    
                    @endforeach
                </tbody>

               </table>
            </div>
        </div>

    </div>
</div>
<!-- End Cart -->

@endsection
