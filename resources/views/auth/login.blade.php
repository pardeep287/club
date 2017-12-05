<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name', 'JB') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom Theme files -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- //Custom Theme files -->
    <!-- web font -->
    <link href="{{ asset('/fonts/font-awesome.min.css') }}" rel="stylesheet">
    <!-- //web font -->
    <!-- //js -->
</head>

<body>
    <!-- main -->
    <div class="main login-logo">
        <img src="{{ asset('/images/logo.png') }}" />
        <div class="main-info">
            @include('layouts.errors')
            <div class="">
                <div class="agileits-login">
                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <input type="text" class="email" name="email" placeholder="email" autocomplete="off" required=""  value="{{ old('email') }}"/>
                        <input type="password" class="password" name="password" placeholder="Password" required="" />
                        <div class="wthree-text">
                            <ul>
                                <li> <a href="#" data-toggle="modal" data-target="#forgot-password">Forgot password?</a> </li>
                            </ul>
                            <div class="clear"> </div>
                        </div>
                        <div class="w3ls-submit">
                            <div class="submit-text">
                                <input type="submit" value="LOGIN">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- copyright -->
        <div class="copyright">
            <p> © 2017 Club JB . All rights reserved | Design & Developed by <a href="#">Club JB</a></p>
        </div>
        <!-- //copyright -->
    </div>
    <!-- //main -->
    <!-- /.modal -->
    <div class="modal fade" id="forgot-password">
        <div class="modal-dialog modal-sm">
            <form action="#" method="post">

                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-lock"></i> Forgot Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label>Enter Your Email</label>
                                    <input type="text" class="form-control"  name="email" value="{{ $email or old('email') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter New Password</label>
                                    <input type="text" class="form-control" id="" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="text" class="form-control" id="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <script src="{{ asset('/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>

</html>