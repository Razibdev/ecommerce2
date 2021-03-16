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
            <div class="col-md-5 col-sm-12">

                <div class="contact-form-right">
                    <h2>New user signup!</h2>
                    <form action="{{url('/user-register')}}" method="POST" id="register">{{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" required placeholder="Your Name" data-error="Please Enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="form-control" required placeholder="Your Email" data-error="Please Enter Your Email">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" required placeholder="Your Password" data-error="Please Enter your password">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="submit-button text-center">
                                        <button class="btn hvr-hover" type="submit" id="hover">SignUp</button>
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
            <div class="col-md-1 col-sm-12" id="or">
                OR
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="contact-form-right">
                    <h2>Already a Member ? Just SignIn</h2>
                    <form action="{{url('/user-login')}}" method="POST" id="LoginForm">{{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="form-control" required placeholder="Your Email" data-error="Please Enter Your Email">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" required placeholder="Your Password" data-error="Please Enter your password">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="submit-button text-center">
                                        <button class="btn hvr-hover" type="submit" id="hover">Login</button>
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
        </div>
    </div>
</div>

@endsection