@extends('wayshop.layouts.master')
@section('content')

<div class="contact-box-main">
    <div class="container">
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
        
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 col-sm-12">
                <div class="contact-form-right">
                    <h2>Change Password</h2>
                    <form action="{{url('/change-address')}}" method="POST" id="changePassword">{{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" required value="{{$userDetails->name}}" data-error="Please Enter Your Name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    
                                    <input type="text" name="address" id="address" class="form-control" required @if (!empty($userDetails->address))value="{{$userDetails->address}}" @else placeholder="Enter Your Address" @endif   data-error="Please Enter Your Address">
                                    <div class="help-block with-errors"></div>
                                </div>

                                

                                <div class="form-group">
                                    <input type="text" name="state" id="state" class="form-control" required @if (!empty($userDetails->state))value="{{$userDetails->state}}" @else placeholder="Enter Your State" @endif data-error="Please Enter Your State">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="city" id="city" class="form-control" required @if (!empty($userDetails->city))value="{{$userDetails->city}}" @else placeholder="Enter Your City" @endif data-error="Please Enter Your City">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group"> 
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}" @if ($country->country_name == $userDetails->country) selected
                                        
                                    @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <input type="text" name="pincode" id="pincode" class="form-control" required @if (!empty($userDetails->pincode))value="{{$userDetails->pincode}}" @else placeholder="Enter Your Pincode" @endif   data-error="Please Enter Your Pincode">
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group">
                                    <input type="text" name="mobile" id="mobile" class="form-control" required @if (!empty($userDetails->mobile))value="{{$userDetails->mobile}}" @else placeholder="Enter Your Mobile" @endif data-error="Please Enter your Mobile">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="submit-button text-center">
                                        <button class="btn hvr-hover" type="submit" id="hover">Update</button>
                                        <div id="msgSubmit" class="h3 text-center hidden">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
           
        </div>
    </div>
</div>

@endsection