@extends('layouts.frontend')
@section('content')


<!--/sliderareas start-->
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-2">
                <div class="left-sidebar">
                    <h2><i class="sc-hd-prefix2-icon sc-hd-prefix2-icon-category sc-hd-prefix2-icon-s"> </i> Categories</h2>
                    <div class="cd-dropdown-wrapper">
                        <nav class="cd-drown">
                            <ul class="cd-dropdown-content">
                                @foreach($categories as $category)
                                <li class="">
                                    <a href="#"><i class="ui2-icon ui2-icon-rfq icon-tag"></i> {{ $category->name }}</a>
                                    <!-- .cd-secondary-dropdown -->
                                </li>
                                @endforeach
                            </ul>
                            <!-- .cd-dropdown-content -->
                        </nav>
                        <!-- .cd-dropdown -->
                    </div>
                    <!-- .cd-dropdown-wrapper -->
                    <!--/category-products-->
                </div>
            </div>
            <div class="col-md-8">
                <div class="header-bottom">
                    <div class="carousel slide" id="myCarousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="bannerImage">
                                    <a href="#"><img src="{{ asset('/frontend/images/home/1.jpg') }}" alt=""></a>
                                </div>
                            </div>
                            <!-- /Slide1 -->
                            <div class="item">
                                <div class="bannerImage">
                                    <a href="#"><img src="{{ asset('/frontend/images/home/2.jpg') }}" alt=""></a>
                                </div>
                            </div>
                            <!-- /Slide1 -->
                        </div>
                        <div class="control-box">
                            <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
                            <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
                        </div>
                        <!-- /.control-box -->
                    </div>
                    <!-- /#myCarousel -->
                </div>
            </div>
            <div class="col-md-2">
                <div class="left-sidebar">
                    <h2>
                        <i class="sc-hd-prefix2-icon ui2-icon-credit-level sc-hd-prefix2-icon-s"> </i>
                        Popular on Club JB
                    </h2>
                    <div class="card">
                        <div class="card_inner">
                            <a href="deals-car.html">
                                <div class="card_image">
                                    <img class="img-responsive" src="{{ asset('/frontend/images/side-img.jpg') }}" alt="">
                                    <!--template bindings={}-->
                                    <div class="card_rating">
                                        <span class="rating-icon"></span> <!--template bindings={}-->
                                        <!--template bindings={}--><span class="rating-score"><i class="fa fa-heart-o"></i> 87</span>
                                    </div>
                                    <!--template bindings={}-->
                                </div>
                                <div class="card_description">
                                    <p class="card_title margin-bottom-xs txt-truncate" title="">Carnival Cinema</p>
                                    <hr class="margin-reset">
                                    <div class="margin-top-s">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="card_discount">
                                                    <!--template bindings={}-->
                                                    <p class="txt-brand-primary font-xs">Rs 100/- Off</p>
                                                </div>
                                            </div>
                                            <div class="col-md-7 nopadding">
                                                <div class="previous-price txt-right">
                                                    <!--template bindings={}-->
                                                    <p class="txt-right txt-tertiary font-xs line-height-xs"><i class="fa fa-inr"></i> 300</p>
                                                </div>
                                                <p class="txt-brand-secondary font-weight-semibold txt-right actual-price"><span class="font-weight-regular h6 txt-brand-secondary"><i aria-hidden="true" class="fa fa-inr margin-reset"></i></span> 200</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card_inner">
                            <a href="deals.html">
                                <div class="card_image">
                                    <img class="img-responsive" src="{{ asset('/frontend/images/side-img2.jpg') }}" alt="">
                                    <!--template bindings={}-->
                                    <div class="card_rating">
                                        <span class="rating-icon"></span> <!--template bindings={}-->
                                        <!--template bindings={}--><span class="rating-score"><i class="fa fa-heart-o"></i> 85</span>
                                    </div>
                                    <!--template bindings={}-->
                                </div>
                                <div class="card_description">
                                    <p class="card_title margin-bottom-xs txt-truncate" title="">Domino's Pizza</p>
                                    <hr class="margin-reset">
                                    <div class="margin-top-s">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="card_discount">
                                                    <!--template bindings={}-->
                                                    <p class="txt-brand-primary font-xs">20% OFF</p>
                                                </div>
                                            </div>
                                            <div class="col-md-7 nopadding">
                                                <div class="previous-price txt-right">
                                                    <!--template bindings={}-->
                                                    <p class="txt-right txt-tertiary font-xs line-height-xs"><i class="fa fa-inr"></i> 500</p>
                                                </div>
                                                <p class="txt-brand-secondary font-weight-semibold txt-right actual-price"><span class="font-weight-regular h6 txt-brand-secondary"><i class="fa fa-inr margin-reset"></i></span> 300</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <div class="big-txt">
                <h2>Fresh Arrivals</h2>
                <div class="border"></div>
            </div>
            <div class="l-idshome-grid">
                <div class="l-idshome-main">
                    <div class="l-idshome-main-wrap">
                        <div class="uf-border">
                            <div class="m-category-cluster">
                                <ul class="items util-clearfix">
                                    @foreach($freshArrivals as $deal)
                                    <li class="item @if($deal->first) expanded @endif" data-role="item">
                                        <div class="wrap">
                                        <div class="title"><a href="{{ route("deals.single", ["id" => $deal->id]) }}">{{ Str::words($deal->title, 5, "...") }}</a></div>
                                            <div class="box">
                                                <div class="col-md-4 img">
                                                    <div class="util-valign img-wrap">
                                                        <div class="card">
                                                            <div class="card_inner">
                                                                <a href="deals-car.html">
                                                                    <div class="card_image">
                                                                        <img class="img-responsive" src="{{ $deal->thumbAvatar() }}" alt="">
                                                                    </div>
                                                                    <div class="card_description">
                                                                        <hr class="margin-reset">
                                                                        <div class="margin-top-s">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <div class="card_discount @if($deal->discountPrice() == 0) hidden @endif">
                                                                                        <!--template bindings={}-->
                                                                                        <p class="txt-brand-primary font-xs">Rs {{ $deal->discountPrice()  }}/- Off</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-7 nopadding">
                                                                                    <div class="previous-price txt-right">
                                                                                        <!--template bindings={}-->
                                                                                        <p class="txt-right txt-tertiary font-xs line-height-xs"><i class="fa fa-inr"></i> {{ $deal->price  }}</p>
                                                                                    </div>
                                                                                    <p class="txt-brand-secondary font-weight-semibold txt-right actual-price">
                                                                                        <span class="font-weight-regular h6 txt-brand-secondary">
                                                                                            <i class="fa fa-inr margin-reset"></i>
                                                                                        </span>
                                                                                        {{ $deal->price - $deal->discountPrice() }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 links">
                                                    <div class="tags">
                                                        {!! Str::words($deal->description, 20, "...") !!}
                                                    </div>
                                                    <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small"><i class="fa fa-heart-o"></i> 87</a>
                                                    <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small"><i class="fa fa-share"></i> Share</a>
                                                    <a href="{{ route("deals.single", ["id" => $deal->id]) }}" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small">View More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="big-txt">
                <h2>My City Hot Deals</h2>
                <div class="border"></div>
            </div>
            <div class="l-idshome-grid  ">
                <div class="l-idshome-main">
                    <div class="l-idshome-main-wrap">
                        <div class="uf-border">
                            <div class="m-category-cluster">
                                <ul class="items util-clearfix">
                                    <li class="item expanded" data-role="item">
                                        <div class="wrap">
                                            <div class="title"><a href="deals-car.html">Carnival Cinemas</a></div>
                                            <div class="box">
                                                <div class="col-md-4 img">
                                                    <div class="util-valign img-wrap">
                                                        <div class="card">
                                                            <div class="card_inner">
                                                                <a href="deals-car.html">
                                                                    <div class="card_image">
                                                                        <img class="img-responsive" src="{{ asset('/frontend/images/side-img.jpg') }}" alt="">
                                                                    </div>
                                                                    <div class="card_description">
                                                                        <hr class="margin-reset">
                                                                        <div class="margin-top-s">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <div class="card_discount">
                                                                                        <!--template bindings={}-->
                                                                                        <p class="txt-brand-primary font-xs">Rs 100/- Off</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-7 nopadding">
                                                                                    <div class="previous-price txt-right">
                                                                                        <!--template bindings={}-->
                                                                                        <p class="txt-right txt-tertiary font-xs line-height-xs"><i class="fa fa-inr"></i> 300</p>
                                                                                    </div>
                                                                                    <p class="txt-brand-secondary font-weight-semibold txt-right actual-price"><span class="font-weight-regular h6 txt-brand-secondary"><i class="fa fa-inr margin-reset"></i></span> 200</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 links">
                                                    <div class="tags">
                                                        Online Movie tickets Booking for theatre chains in India. Check out Theatre Address, Prices, Rates, Film Shows, Movies & Cinemas Show ...
                                                    </div>
                                                    <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small"><i class="fa fa-heart-o"></i> 87</a>
                                                    <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small"><i class="fa fa-share"></i> Share</a>
                                                    <a href="deals-car.html" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small">View More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="big-txt">
                <h2>Top Picks</h2>
                <div class="border"></div>
            </div>
            <div class="l-idshome-grid  ">
                <div class="l-idshome-main">
                    <div class="l-idshome-main-wrap">
                        <div class="uf-border">
                            <div class="m-category-cluster">
                                <ul class="items util-clearfix">
                                    @foreach($storeTopPicks as $store)
                                        <li class="item @if($store->first) expanded @endif" data-role="item">
                                            <div class="wrap">
                                                <div class="title"><a href="deals-car.html">{{ $store->name }}</a></div>
                                                <div class="box">
                                                    <div class="col-md-4 img">
                                                        <div class="util-valign img-wrap">
                                                            <div class="card">
                                                                <div class="card_inner">
                                                                    <a href="deals-car.html">
                                                                        <div class="card_image">
                                                                            <img class="img-responsive" src="{{ $store->imageAvatar() }}" alt="">
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 links">
                                                        <div class="tags">
                                                            {!! Str::words($store->terms, 50, "...") !!}
                                                        </div>
                                                        <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small">View Deals</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection