@extends("layouts.frontend")
@section("content")
<!--/sliderareas start-->
<div class="row">
    <div class="container">
        <div class="col-md-12 breadcrumbs-top">
            <div class="col-md-6">
                <div class="breadcrumbs-outer">
                    <div class="breadcrumbs-outer">
                        <nav class="breadcrumbs">
                            <a href="#">Home</a> <i></i><a href="#">ALL OFFERS</a> <!--template bindings={}--><a href="#">Spa &amp; Massage</a> <!--template bindings={}--> <!--template bindings={}-->
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-6 sorting_filter">
                <div class="sorter sort-buttons flt-right">
                    <!--template bindings={}--><button class="active">Popular</button><button>What's New</button><button >Price (High to Low)</button><button>Price (Low to High)</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2">
                <div class="left-sidebar">
                    <div class="filter-wrapper">
                        <!--template bindings={}-->
                        <aside class="filter-categories">
                            <h4 class="font-weight-light margin-bottom-m category-heading">Categories</h4>
                            <!--template bindings={}-->
                            <ul class="list-block margin-bottom-s" id="ul-location-filter">
                                <!--template bindings={}-->
                                <li class="margin-bottom-s open">
                                    <!--template bindings={}--><a class="menu-header">Spa & Massage</a> <!--template bindings={}-->
                                    <div class="sublocation-wrapper">
                                        <ul class="list-block">
                                            <!--template bindings={}-->
                                            <li>
                                                <label class="nb-checkbox full-width">
                                                    <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                    <div class="nb-checkbox_bg">
                                                        <div class="nb-checkbox_icon"></div>
                                                    </div>
                                                    <span class="txt-primary padding-left-xs">Facial <span class="count flt-right">(29)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="nb-checkbox full-width">
                                                    <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                    <div class="nb-checkbox_bg">
                                                        <div class="nb-checkbox_icon"></div>
                                                    </div>
                                                    <span class="txt-primary padding-left-xs">Full Body Massage <span class="count flt-right">(19)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="nb-checkbox full-width">
                                                    <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                    <div class="nb-checkbox_bg">
                                                        <div class="nb-checkbox_icon"></div>
                                                    </div>
                                                    <span class="txt-primary padding-left-xs">Rebonding <span class="count flt-right">(14)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="nb-checkbox full-width">
                                                    <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                    <div class="nb-checkbox_bg">
                                                        <div class="nb-checkbox_icon"></div>
                                                    </div>
                                                    <span class="txt-primary padding-left-xs">Hair Color <span class="count flt-right">(12)</span> </span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="nb-checkbox full-width">
                                                    <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                    <div class="nb-checkbox_bg">
                                                        <div class="nb-checkbox_icon"></div>
                                                    </div>
                                                    <span class="txt-primary padding-left-xs">Manicure & Pedicure <span class="count flt-right">(10)</span> </span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </aside>
                        <!--template bindings={}-->
                        <hr class="divider">
                        <aside class="filter-location">
                            <!--template bindings={}-->
                            <aside class="filter-location">
                                <h5 class="margin-bottom-m"><b>Location</b></h5>
                                <input class="form-group form-control ng-untouched ng-pristine ng-valid" placeholder="Search for a location" type="search">
                                <ul class="list-block margin-bottom-s" id="ul-location-filter">
                                    <!--template bindings={}-->
                                    <li class="margin-bottom-s open">
                                        <!--template bindings={}--><a class="menu-header">Mumbai</a> <!--template bindings={}-->
                                        <div class="sublocation-wrapper">
                                            <ul class="list-block">
                                                <!--template bindings={}-->
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Andheri West <span class="count flt-right">(29)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Bandra West <span class="count flt-right">(19)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Juhu <span class="count flt-right">(14)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Andheri East <span class="count flt-right">(12)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Borivali West <span class="count flt-right">(10)</span> </span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="margin-bottom-s open">
                                        <!--template bindings={}--><a class="menu-header">Thane</a> <!--template bindings={}-->
                                        <div class="sublocation-wrapper">
                                            <ul class="list-block">
                                                <!--template bindings={}-->
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Thane West <span class="count flt-right">(15)</span> </span>
                                                    </label>
                                                </li>
                                                <li >
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Mira Bhayandar <span class="count flt-right">(9)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Thane East <span class="count flt-right">(1)</span> </span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <!--template bindings={}-->
                                        </div>
                                    </li>
                                    <li class="margin-bottom-s open">
                                        <!--template bindings={}--><a class="menu-header">Navi Mumbai</a> <!--template bindings={}-->
                                        <div class="sublocation-wrapper">
                                            <ul class="list-block">
                                                <!--template bindings={}-->
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Vashi <span class="count flt-right">(8)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Kharghar <span class="count flt-right">(3)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Kopar Khairane <span class="count flt-right">(3)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Sanpada <span class="count flt-right">(3)</span> </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="nb-checkbox full-width">
                                                        <input name="location" class="ng-untouched ng-pristine ng-valid" type="checkbox" name="" id="">
                                                        <div class="nb-checkbox_bg">
                                                            <div class="nb-checkbox_icon"></div>
                                                        </div>
                                                        <span class="txt-primary padding-left-xs">Seawoods <span class="count flt-right">(2)</span> </span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <!--template bindings={}-->
                            </aside>
                        </aside>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="deal-pages">
                        @foreach($deals as $deal)
                            @php
                            $discount = Helpers_Common::calculateDiscount($deal->discount_type, $deal->discount_value, $deal->price);
                            @endphp
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card_inner">
                                    <a href="#">
                                        <div class="card_image">
                                            <img class="img-responsive" src="images/side-img.jpg" alt="" width="261">
                                            <!--template bindings={}-->
                                            <div class="card_rating">
                                                <span class="rating-icon"></span> <!--template bindings={}-->
                                                <!--template bindings={}--><span class="rating-score"><i class="fa fa-heart-o"></i> 87</span>
                                            </div>
                                            <!--template bindings={}-->
                                        </div>
                                        <div class="card_description">
                                            <div class="card_title margin-bottom-xs txt-truncate" title="">{{ $deal->title }}</div>
                                            <p class="lit-txt">{{ $deal->city_name }}</p>
                                            <div class="card_option txt-secondary margin-bottom-m lit-txt2" title="">{!! $deal->description !!}</div>
                                            <hr class="margin-reset">
                                            <div class="margin-top-s">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="card_discount">
                                                            <!--template bindings={}-->
                                                            <p class="txt-brand-primary font-xs">Rs {{ $discount }}/- Off</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 nopadding">
                                                        <div class="previous-price txt-right">
                                                            <!--template bindings={}-->
                                                            <p class="txt-right txt-tertiary font-xs line-height-xs"><i aria-hidden="true" class="fa fa-inr"></i> {{ $deal->price }}</p>
                                                        </div>
                                                        <p class="txt-brand-secondary font-weight-semibold txt-right actual-price"><span class="font-weight-regular h6 txt-brand-secondary"><i aria-hidden="true" class="fa fa-inr margin-reset"></i></span> {{ $deal->price - $discount }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="dividerspace"></div>
@endsection