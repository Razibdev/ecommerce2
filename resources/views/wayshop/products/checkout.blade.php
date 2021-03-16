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
        <form action="{{url('/checkout')}}" method="POST" id="register">{{ csrf_field() }}
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="contact-form-right">
                    <h2>Bill To!</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <input type="text" name="billing_name" id="billing_name" class="form-control" required @if (!empty($userDetails->name))value="{{$userDetails->name}}" @else placeholder="Billing Name" @endif data-error="Enter Your Billing Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="billing_address" id="billing_address" class="form-control" required @if (!empty($userDetails->address))value="{{$userDetails->address}}" @else placeholder="Billing Address" @endif data-error="Enter Your Billing Address">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="billing_city" id="billing_city" class="form-control" required @if (!empty($userDetails->city))value="{{$userDetails->city}}" @else placeholder="Billing City" @endif data-error="Please Enter Billing city">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="billing_state" id="billing_state" class="form-control" @if (!empty($userDetails->state))value="{{$userDetails->state}}" @else placeholder="Billing State" @endif data-error="Please Enter your Billing State">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <select name="billing_country" id="billing_country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                    <option value="{{$country->country_name}}" @if (!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>{{$country->country_name}}</option>
                                        @endforeach
                                   
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="billing_pincode" id="billing_pincode" class="form-control" required @if (!empty($userDetails->pincode))value="{{$userDetails->pincode}}" @else placeholder="Billing Pincode" @endif data-error="Please Enter your Billing Pincode">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="billing_mobile" id="billing_mobile" class="form-control" required @if (!empty($userDetails->mobile))value="{{$userDetails->mobile}}" @else placeholder="Billing Mobile Number" @endif data-error="Please Enter your Billing Mobile Number">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-gorup" style="margin-left: 30px;">
                                        <input type="checkbox" name="billtoship" id="billtoship" class="form-check-input">
                                        <label for="billtoship"  class="form-check-label">Shipping Address Same As Billing Address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-12">
                <div class="contact-form-right">
                    <h2>Ship To</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                
                                <input type="text" name="shipping_name" id="shipping_name" class="form-control" required  @if (!empty($shippingDetails->name))value="{{$shippingDetails->name}}" @else placeholder="Shipping Name" @endif  data-error="Enter Your Shipping Name">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping_address" id="shipping_address" class="form-control" required @if (!empty($shippingDetails->address))value="{{$shippingDetails->address}}" @else placeholder="Shipping Address" @endif  data-error="Enter Your Shipping Address">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="shipping_city" id="shipping_city" class="form-control" required @if (!empty($shippingDetails->city))value="{{$shippingDetails->city}}" @else placeholder="Shipping City" @endif  data-error="Please Enter Shipping city">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="shipping_state" id="shipping_state" class="form-control" required @if (!empty($shippingDetails->state))value="{{$shippingDetails->state}}" @else placeholder="Shipping State" @endif  data-error="Please Enter your Shipping State">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                               <select name="shipping_country" id="shipping_country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->country_name}}" @if (!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{$country->country_name}}</option>
                                @endforeach
                               </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="shipping_pincode" id="shipping_pincode" class="form-control" required @if (!empty($shippingDetails->pincode))value="{{$shippingDetails->pincode}}" @else placeholder="Shipping Pincode" @endif  data-error="Please Enter your Shipping Pincode">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="shipping_mobile" id="shipping_mobile" class="form-control" required @if (!empty($shippingDetails->mobile))value="{{$shippingDetails->mobile}}" @else placeholder="Shipping Mobile" @endif  data-error="Please Enter your Shipping mobile number">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="col-md-12">
                                <div class="submit-button text-center">
                                    <button type="submit" class="btn hvr-hover">Checkout</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection