<!DOCTYPE HTML>
<html>
   <head>
      <title>Club JB</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="keywords" content="" />
      <!-- Bootstrap Core CSS -->
      <link href="{{ asset('css/bootstrap.min.css') }}" rel='stylesheet' type='text/css' />
      <!-- Custom CSS -->
      <link href="{{ asset('css/thnx.css') }}" rel='stylesheet' type='text/css' />
      <!-- Font Awesome CSS -->
      <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
   </head>
   <body>
      <div class="container">
         <div class="col-md-12 no-padding">
            <div class="logo">
                <img src="{{ asset('images/logo-small.png') }}" class="img-responsive" />
            </div>
            <div class="successfull-inner color-red">
               <i class="fa fa-exclamation-triangle"></i>
               <h3>Security Issue</h3>
               <p>{{ $transaction->message }}</p>
            </div>
            <div class="bottom-btns">
                <a href="{{route('cc_done')}}" class="btn btn-primary">OK</a>
            </div>
         </div>
      </div>
   </body>
</html>