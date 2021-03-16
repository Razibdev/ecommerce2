@extends('admin.layouts.master')
@section('title', 'View Products')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="header-icon">
        <i class="fa fa-users"></i>
    </div>
    <div class="header-title">
        <h1>View Products</h1>
        <small>Products List</small>
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

<div id="message_success" style="display: none;" class="alert alert-sm alert-success"> Status Enable</div>
<div id="message_error" style="display: none;" class="alert alert-sm alert-danger"> Status Disabled</div>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                    <a href="#">
                        <h4>View Products</h4>
                    </a>
                </div>
            </div>
            <div class="panel-body">
            <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                <div class="btn-group">
                    <div class="buttonexport" id="buttonlist"> 
                        <a class="btn btn-add" href="{{url('admin/add-product')}}"> <i class="fa fa-plus"></i> Add Product
                        </a>  
                    </div>
                </div>

                <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                <div class="table-responsive">
                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="info">
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Product Color</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Featured Products</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                
                        <tr>
                            <td>
                                @if (!empty($product->image))
                                <img src="{{asset('/uploads/products/'.$product->image)}}" alt="Product Image" width="100"> 
                                @endif
                                
                            </td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->code}}</td>
                            <td>{{$product->color}}</td>
                            <td>{{$product->price}}</td>
                        <td>
                            <input type="checkbox" class="ProductStatus btn btn-success" rel="{{$product->id}}" data-toggle="toggle" data-on="Enable" data-off="Disabled" data-onstyle="success" data-offstyle="danger" @if ($product['status'] == "1") checked @endif >
                            <div id="myElem" style="display:none;" class="alert alert-success"> Status Enable</div>
                        </td>
                        <td>
                            <input type="checkbox" class="FeaturedStatus btn btn-success" rel="{{$product->id}}" data-toggle="toggle" data-on="Enable" data-off="Disabled" data-onstyle="success" data-offstyle="danger" @if ($product['status'] == "1") checked @endif >
                            <div id="myElem" style="display:none;" class="alert alert-success"> Status Enable</div>
                        </td>
                        <td>
                        <a href="{{url('/admin/add-images/'.$product->id)}}" class="btn btn-info btn-sm" title="Add Images"><i class="fa fa-image"></i></a>
                        <a href="{{url('/admin/add-attributes/'.$product->id)}}" class="btn btn-warning btn-sm" title="Add Attributes"><i class="fa fa-list"></i></a>
                        <a href="{{url('/admin/edit-product/'.$product->id)}}" class="btn btn-add btn-sm" title="Edit Product"><i class="fa fa-pencil"></i></a>
                        <a href="{{url('/admin/delete-product/'.$product->id)}}" class="btn btn-danger btn-sm"  title="Delete Product"><i class="fa fa-trash-o"></i> </a>
                        </td>
                        </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
 
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection