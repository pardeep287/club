<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Club JB - Internet Marketing &amp; Media Promotion Company.</title>
    <link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.png') }}">
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('/frontend/js/jquery-3.2.1.min.js') }}"></script>
</head>
<body>
<!--/header_top start-->
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu">
                    <span class="logo"><a href="/"><img src="{{ asset('/frontend/images/logo.png') }}" alt="" /></a></span>
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li class="help-nav"><a href="{{ route("deals.index") }}" >All Deals</a></li>
                        <li><a href="#" >Top 12</a></li>
                    </ul>
                </div>
                <div class="contactinfo">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li><a href="#"><i class="fa fa-phone"></i> +91 81960 81960</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> info@clubjb.com</a></li>
                    </ul>
                    <a href="https://play.google.com/store/apps/details?id=net.digiguru.clubjb" class="top-advt" target="blank"><img src="{{ asset('/frontend/images/google_play.png') }}" alt=""/></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="login-here pull-right">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li class="help-nav"><a href="#">Help</a></li>
                        <li><a href="#">List Your Business</a></li>
                        <li><a href="#"><i class="fa fa-bell"></i> </a></li>
                        <nav class="main-nav">
                            <li><a href="#0" class="btn btn-primary cd-signup"><i class="fa fa-user-plus"></i> Sign Up</a></li>
                            <li><a href="#0" class="btn btn-primary cd-signin"  data-toggle="modal" data-target="#login"><i class="fa fa-user"></i> Login</a></li>
                        </nav>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/header_top end-->
<!--/searcharea start-->
<div class="header_top2">
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="quick-search">
                        <div class="row">
                            <form role="form" method="post">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" id="searchcategory" value="" class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="modal" data-target="#city-popup">
                                            <div class="col-md-2 nopadding">
                                                <div class="map-marker"><i class="ui2-icon ui2-icon-map icon-tag"></i></div>
                                            </div>
                                            <div class="col-md-10 text-left nopadding display-no">
                                                <span>Search Within</span>
                                                New Delhi
                                            </div>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" value="" placeholder="Search restaurants, spa, events, things to do..." name="" id="">
                                    <span class="input-group-btn">
                                 <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                 </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/searcharea end-->


@yield('content')


<footer id="footer">
    <!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div >
                    <div class="companyinfo">
                        <h2><span>About</span>-us</h2>
                        <div class="abttxt">At clubjb, our vision is to be Earth's most customer centric company; to build a place where people can come to find and discover virtually anything they want to buy online. With clubjb.in, we endeavour to build that same destination in India by giving customers more of what they want – vast selection, low prices, fast and reliable delivery, and a trusted and convenient online shopping experience – and provide sellers a world-class e-commerce platform. We are committed to ensure 100% Purchase Protection for your shopping done on clubjb.in so that you can benefit from a safe and secure online ordering experience, convenient payment options such as cash on delivery, easy returns and enjoy a completely hassle free online shopping experience.
                            We launched with Books and Movies & TV Shows and have expanded our offerings to include the Kindle family of E-Readers, the clubjb Fashion Store and various products under different categories. Customers can now buy products from popular brands across categories such as Samsung mobiles, Dell laptops, Canon cameras, Fastrack watches and many more at clubjb.in. Don't forget to check out the clubjb Exclusives Store and also, shop for Today's Deals on clubjb and save big every day. On clubjb shopping is not only about buying, it's also about gifting and through Gift A Smile you can give products online to charity through verified NGOs. It is still "Day 1" and we will relentlessly focus on expanding selection and raising the bar for customer experience and online shopping in India.
                            Customers can also shop our full selection of products using the clubjb App for Android, iOS and Windows which offers customers a convenient, fast and secure way to search, browse, compare offers, and shop online quickly and easily, at anytime from anywhere.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Change Location</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quick Link</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Foods</a></li>
                            <li><a href="#">Movies</a></li>
                            <li><a href="#">Shopping</a></li>
                            <li><a href="#">Saloon</a></li>
                            <li><a href="#">Water Park</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                            <li><a href="#">Billing System</a></li>
                            <li><a href="#">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Club JB</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>News Letter</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Your email address" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <!--<p>Get the most recent updates from <br />our site and be updated your self...</p>-->
                        </form>
                    </div>
                    <div class="wpr">
                        <a class="social" id="twitter" href="#" title="">
                            <div class="icon"></div>
                            <div class="shutter_frame">
                                <div class="shutter">
                                    <div class="number">1189</div>
                                    <div class="bar"></div>
                                    <div class="text">Tweet</div>
                                </div>
                            </div>
                        </a>
                        <a class="social" id="google" href="#" title="">
                            <div class="icon"></div>
                            <div class="shutter_frame">
                                <div class="shutter">
                                    <div class="number">421</div>
                                    <div class="bar"></div>
                                    <div class="text">+1</div>
                                </div>
                            </div>
                        </a>
                        <a class="social" id="facebook" href="#" title="">
                            <div class="icon"></div>
                            <div class="shutter_frame">
                                <div class="shutter">
                                    <div class="number">973</div>
                                    <div class="bar"></div>
                                    <div class="text">Like</div>
                                </div>
                            </div>
                            <!-- / .shutter_frame -->
                        </a>
                    </div>
                    <!-- / .wpr -->
                </div>
            </div>
        </div>
    </div>
    <div class="dividerspace"></div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2016 Club JB. All rights reserved.</p>
                <p class="pull-right">Designed by: <a target="_blank" href="#">clubjb.com</a></p>
            </div>
        </div>
    </div>
</footer>
<!--/Footer-->
<div class="cd-user-modal">
    <!-- this is the entire modal form, including the background -->
    <div class="cd-user-modal-container">
        <!-- this is the container wrapper -->
        <ul class="cd-switcher">
            <li><a href="#"><i class="fa fa-user"></i> Log in</a></li>
            <li><a href="#"><i class="fa fa-user-plus"></i> Sign up</a></li>
        </ul>
        <div id="cd-login">
            <!-- log in form -->
            <form class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-email" for="signin-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail">
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="fieldset">
                    <label class="image-replace cd-password" for="signin-password">Password</label>
                    <input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="Password">
                    <a href="#" class="hide-password">Hide</a>
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-block btn-social btn-facebook">
                            <span class="fa fa-facebook"></span> Sign in with Facebok
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-block btn-social btn-twitter">
                            <span class="fa fa-twitter"></span> Sign in with Twitter
                        </a>
                    </div>
                </div>
                <p class="fieldset">
                    <input class="full-width" type="submit" value="Login">
                </p>
            </form>
            <!-- <a href="#0" class="cd-close-form">Close</a> -->
        </div>
        <!-- cd-login -->
        <div id="cd-signup">
            <!-- sign up form -->
            <form class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">Username</label>
                    <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username">
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="fieldset">
                    <label class="image-replace cd-email" for="signup-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-password">Password</label>
                    <input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password">
                    <a href="#" class="hide-password">Hide</a>
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Create account">
                </p>
            </form>
        </div>
        <!-- cd-signup -->
        <div id="cd-reset-password">
            <!-- reset password form -->
            <p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>
            <form class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
                    <span class="cd-error-message">Error message here!</span>
                </p>
                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Reset password">
                </p>
            </form>
            <p class="cd-form-bottom-message btn-back"><a href="#0"><i class="fa fa-angle-left"></i> Back to log-in</a></p>
        </div>
        <!-- cd-reset-password -->
        <a href="#" class="cd-close-form">Close</a>
    </div>
    <!-- cd-user-modal-container -->
</div>
<!-- cd-user-modal -->
<!-- Modal -->
<div class="modal fade" id="city-popup" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content city-modal">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal_header-image txt-center txt-tertiary padding-top-s padding-bottom-s">
                    <p class="font-weight-regular txt-brand-primary margin-top-xs">37 cities.</p>
                    <p class="icon-m txt-tertiary margin-top-xs margin-bottom-l"> We surely have something for you.</p>
                    <p class="txt-primary"> Pick a city. </p>
                    <p class="txt-tertiary margin-top-xs">We'd love to make your day!</p>
                    <div class="col-md-7 col-md-offset-3 search-city">
                        <form method="post">
                            <input class="form-control" placeholder="Enter City Name" type="text" name="" id="">
                            <i class="fa fa-map-marker"></i>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <p class="txt-left txt-primary">Top Cities</p>
                <hr>
                <div class="location_city">
                    <ul>
                        <!--template bindings={}-->
                        <li class="active"> <a href="#">New Delhi</a></li>
                        <li> <a href="#">Gurgaon</a></li>
                        <li> <a href="#">Bengaluru</a></li>
                        <li> <a href="#">Mumbai</a></li>
                        <li> <a href="#">Kolkata</a></li>
                        <li> <a href="#">Hyderabad</a></li>
                        <li> <a href="#">Chennai</a></li>
                        <li> <a href="#">Chandigarh</a></li>
                        <li> <a href="#">Jaipur</a></li>
                        <li> <a href="#">Pune</a></li>
                        <li> <a href="#">Ahmedabad</a></li>
                        <li> <a href="#">Goa</a></li>
                        <li> <a href="/#">Noida</a></li>
                        <li> <a href="#">Faridabad</a></li>
                    </ul>
                </div>
                <p class="h6 margin-top-l txt-left txt-primary">Other Cities</p>
                <hr>
                <div class="location_city">
                    <ul>
                        <!--template bindings={}-->
                        <li> <a href="#">Agra</a> </li>
                        <li> <a href="#">Amritsar</a> </li>
                        <li> <a href="#">Aurangabad</a> </li>
                        <li> <a href="#">Coimbatore</a> </li>
                        <li> <a href="#">Dehradun</a> </li>
                        <li> <a href="#">Ghaziabad</a> </li>
                        <li> <a href="#">Greater Noida</a> </li>
                        <li> <a href="#">Guwahati</a> </li>
                        <li> <a href="#">Indore</a> </li>
                        <li> <a href="#">Jodhpur</a> </li>
                        <li> <a href="#">Kanpur</a> </li>
                        <li> <a href="#">Kochi</a> </li>
                        <li> <a href="#">Lucknow</a> </li>
                        <li> <a href="#">Ludhiana</a> </li>
                        <li> <a href="#">Meerut</a> </li>
                        <li> <a href="#">Mysore</a> </li>
                        <li> <a href="#">Nagpur</a> </li>
                        <li> <a href="#">Pondicherry</a> </li>
                        <li> <a href="#">Shimla</a> </li>
                        <li> <a href="#">Surat</a> </li>
                        <li> <a href="#">Udaipur</a> </li>
                        <li> <a href="#">Vadodara</a> </li>
                        <li> <a href="#">Visakhapatnam</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.social').hover(
            function() {
                $(this).find('.shutter').stop(true, true).animate({
                        bottom: '-36px'
                    },
                    {
                        duration: 300,
                        easing: 'easeOutBounce'
                    });
            },
            function () {
                $(this).find('.shutter').stop(true, true).animate({
                        bottom: 0
                    },
                    {
                        duration: 300,
                        easing: 'easeOutBounce'
                    });
            }
        );

    });
</script>
<script>
    jQuery(document).ready(function($){
        var formModal = $('.cd-user-modal'),
            formLogin = formModal.find('#cd-login'),
            formSignup = formModal.find('#cd-signup'),
            formForgotPassword = formModal.find('#cd-reset-password'),
            formModalTab = $('.cd-switcher'),
            tabLogin = formModalTab.children('li').eq(0).children('a'),
            tabSignup = formModalTab.children('li').eq(1).children('a'),
            forgotPasswordLink = formLogin.find('.cd-form-bottom-message a'),
            backToLoginLink = formForgotPassword.find('.cd-form-bottom-message a'),
            mainNav = $('.main-nav');

        //open modal
        mainNav.on('click', function(event){
            $(event.target).is(mainNav) && mainNav.children('ul').toggleClass('is-visible');
        });

        //open sign-up form
        mainNav.on('click', '.cd-signup', signup_selected);
        //open login-form form
        mainNav.on('click', '.cd-signin', login_selected);

        //close modal
        formModal.on('click', function(event){
            if( $(event.target).is(formModal) || $(event.target).is('.cd-close-form') ) {
                formModal.removeClass('is-visible');
            }
        });
        //close modal when clicking the esc keyboard button
        $(document).keyup(function(event){
            if(event.which=='27'){
                formModal.removeClass('is-visible');
            }
        });

        //switch from a tab to another
        formModalTab.on('click', function(event) {
            event.preventDefault();
            ( $(event.target).is( tabLogin ) ) ? login_selected() : signup_selected();
        });

        //hide or show password
        $('.hide-password').on('click', function(){
            var togglePass= $(this),
                passwordField = togglePass.prev('input');

            ( 'password' == passwordField.attr('type') ) ? passwordField.attr('type', 'text') : passwordField.attr('type', 'password');
            ( 'Hide' == togglePass.text() ) ? togglePass.text('Show') : togglePass.text('Hide');
            //focus and move cursor to the end of input field
            passwordField.putCursorAtEnd();
        });

        //show forgot-password form
        forgotPasswordLink.on('click', function(event){
            event.preventDefault();
            forgot_password_selected();
        });

        //back to login from the forgot-password form
        backToLoginLink.on('click', function(event){
            event.preventDefault();
            login_selected();
        });

        function login_selected(){
            mainNav.children('ul').removeClass('is-visible');
            formModal.addClass('is-visible');
            formLogin.addClass('is-selected');
            formSignup.removeClass('is-selected');
            formForgotPassword.removeClass('is-selected');
            tabLogin.addClass('selected');
            tabSignup.removeClass('selected');
        }

        function signup_selected(){
            mainNav.children('ul').removeClass('is-visible');
            formModal.addClass('is-visible');
            formLogin.removeClass('is-selected');
            formSignup.addClass('is-selected');
            formForgotPassword.removeClass('is-selected');
            tabLogin.removeClass('selected');
            tabSignup.addClass('selected');
        }

        function forgot_password_selected(){
            formLogin.removeClass('is-selected');
            formSignup.removeClass('is-selected');
            formForgotPassword.addClass('is-selected');
        }

        //REMOVE THIS - it's just to show error messages
        formLogin.find('input[type="submit"]').on('click', function(event){
            event.preventDefault();
            formLogin.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
        });
        formSignup.find('input[type="submit"]').on('click', function(event){
            event.preventDefault();
            formSignup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
        });


        //IE9 placeholder fallback
        //credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
        if(!Modernizr.input.placeholder){
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.val(input.attr('placeholder'));
                }
            }).blur();
            $('[placeholder]').parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
        }

    });


    //credits http://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
    jQuery.fn.putCursorAtEnd = function() {
        return this.each(function() {
            // If this function exists...
            if (this.setSelectionRange) {
                // ... then use it (Doesn't work in IE)
                // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
                var len = $(this).val().length * 2;
                this.focus();
                this.setSelectionRange(len, len);
            } else {
                // ... otherwise replace the contents with itself
                // (Doesn't work in Google Chrome)
                $(this).val($(this).val());
            }
        });
    };
</script>
<script src="{{ asset('/frontend/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('/frontend/js/jquery.menu-aim.js') }}"></script> <!-- menu aim -->
<script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/frontend/js/price-range.js') }}"></script>
<script src="{{ asset('/frontend/js/main.js') }}"></script>
</body>
</html>