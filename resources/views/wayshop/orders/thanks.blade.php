@extends('wayshop.layouts.master')
@section('content')

 <!-- Start Cart  -->
 <div class="cart-box-main">
    <div class="container">
        <h1 class="text-center">Thanks for Purchasing with us</h1><br><br>
        <div class="row">
            <div class="col-lg-12">
                <div align="center">
                    <h2>Your cod order has been placed</h2>
                    <p>Your order number is {{Session::get('order_id')}} and payable about is $ {{Session::get('grand_total')}}</p>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Cart -->

@endsection

<?php 
 Session::forget('order_id');
 Session::forget('grand_total');

?>