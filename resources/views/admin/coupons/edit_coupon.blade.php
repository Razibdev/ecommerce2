@extends('admin.layouts.master')
@section('title', 'Edit Coupon')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="header-icon">
        <i class="fa fa-product-hunt"></i>
    </div>
    <div class="header-title">
        <h1>Edit Coupon</h1>
        <small>Edit Coupon</small>
    </div>
</section>

@if(Session::has('flash_message_error'))
<div class="alert alert-sm alert-danger alert-block" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!! session('flash_message_error') !!}</strong>
</div>
@endif

@if(Session::has('flash_message_success'))
<div class="alert alert-sm alert-success alert-block" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!! session('flash_message_success') !!}</strong>
</div>
@endif


<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonlist"> 
                    <a class="btn btn-add " href="{{url('admin/view-coupons')}}"> 
                    <i class="fa fa-eye"></i> View Coupons </a>  
                </div>
            </div>
            <div class="panel-body">
            <form class="col-sm-6" enctype="multipart/form-data" action="{{url('admin/edit-coupon/'.$couponDetails->id)}}" name="edit_coupon" id="edit_coupon" method="post">{{ csrf_field() }}
                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input type="text" class="form-control" value="{{$couponDetails->coupon_code}}" name="coupon_code" id="coupon_code" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" value="{{$couponDetails->amount}}" id="coupon_amount" name="coupon_amount"  required>
                    </div>

                    <div class="form-group">
                        <label>Amount Type</label>
                        <select name="amount_type" id="amount_type" class="form-control">
                            <option @if ($couponDetails->amount_type == "Percentage") selected @endif value="Percentage">Percentage</option>
                            <option @if ($couponDetails->amount_type == "Fixed") selected @endif value="Fixed">Fixed</option>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="text" class="form-control"  name="expiry_date" id="expiry_date" value="{{$couponDetails->expiry_date}}" required>
                    </div>
                    
                    <div class="reset-button">
                        <input type="submit" value="Edit Coupon" class="btn btn-success">
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection