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
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Size</th>
                        <th>Product Price</th>
                        <th>Product Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderDetails->orders as $pro)
                    <tr>
                        <td>{{$pro->product_code}}</td>
                        <td>{{$pro->product_name}}</td>
                        <td>{{$pro->product_size}}</td>
                        <td>{{$pro->product_price}}</td>
                        <td>{{$pro->product_qty}}</td>
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
