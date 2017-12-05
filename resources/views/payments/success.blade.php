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
            <div class="successfull-inner">
               <i class="fa fa-check"></i>
               <h3>Payment Complete</h3>
               <p>Thanks for using <strong>Club JB</strong></p>
               <p>{{ $transaction->message }}</p>
               <hr/>
               <h4>Coupon Code</h4>
               <h2>{{ $transaction->report['code'] }}</h2>
               <p>{{ $transaction->report['remarks'] }}</p>

               <p>
                   <small>
                       You can always view your used coupons under 'My coupons' section found within 'My Profile'
                   </small>
               </p>
            </div>
            <div class="bottom-btns">
               <div class="thnx-img"><img src="{{ asset('images/thnx.png') }}" class="img-responsive" /></div>
               <a href="{{route('cc_done')}}" class="btn btn-primary">OK</a>
               <button type="button" class="btn btn-primary hidden">Ok</button>
               <button type="button" class="btn btn-default hidden">Cancel</button>
            </div>
         </div>
      </div>
   </body>
</html>