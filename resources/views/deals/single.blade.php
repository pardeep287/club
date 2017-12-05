@extends("layouts.frontend")
@section("content")
    <!--/sliderareas start-->
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="deal-detail-local">
                    <div class="common-offer-card">
                        <div class="block offer-card">
                            <div class="row row-no-gutter">
                                <div class="col-md-8 nopadding">
                                    <!--template bindings={}-->
                                    <div class="col-md-12 nopadding">
                                        <div class="col-md-8 nopadding lightbox-images">
                                            <a data-caption="Carnival Cinemas (+3 Locations)" data-fancybox="gallery" href="{{ $deal->imageAvatar() }}">
                                                <img src="{{ $deal->imageAvatar() }}" class="image-responsive" alt=""/>
                                            </a>
                                        </div>
                                        <!--<div class="col-md-4 thumb-images">
                                            <a data-caption="Carnival Cinemas (+3 Locations)" data-fancybox="gallery" href="images/carnival2.jpg"><img src="images/carnival2.jpg" class="image-responsive" alt=""/></a>
                                            <hr/>
                                            <a data-caption="Carnival Cinemas (+3 Locations)" data-fancybox="gallery" href="images/carnival3.jpg"><img src="images/carnival3.jpg" class="image-responsive" alt=""/> </a>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="offer-card_content">
                                        <div class="merchant-details">
                                            <!--template bindings={}-->
                                            <h4><b>{{ $deal->title }}</b></h4>
                                            <!--template bindings={}--> <!--template bindings={}--> <!--template bindings={}-->
                                            <div class="about">
                                                <div class="about-content show-more">
                                                    <p>{!! $deal->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="margin-top-m btngroup-inline deal-fav-wrapper">
                                            <!--template bindings={}--> <!--template bindings={}-->
                                            <div class="rating-section">
                                                <div class="rating">
                                                    <div class="rating_inner"> <span class="rating-icon"></span> </div>
                                                    <!--template bindings={}--><span class="rating-score">3.3</span>
                                                </div>
                                            </div>
                                            <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small" ><i class="fa fa-share"></i> Share</a>
                                            <a href="#" class="ui2-button ui2-button-default ui2-button-normal ui2-button-small" ><i class="fa fa-heart-o"></i> 87</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="option hidden">
                                <!--template bindings={}--> <!--template bindings={}--> <!--template bindings={}-->
                                <div class="block">
                                    <div class="table">
                                        <div class="table_cell option-list-wrapper show-on-desktop-display-table">
                                            <div class="option_list">1</div>
                                        </div>
                                        <div class="table_cell">
                                            <div class="block_inner">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <p class="option_title txt-primary">Food Voucher worth Rs.500 (Only 1 Per Customer)</p>
                                                        <!--template bindings={}--> <!--template bindings={}-->
                                                        <ul class="option_validity">
                                                            <!--template bindings={}-->
                                                            <li> <span class="field">Valid for: </span> <span class="value">1 Person</span> </li>
                                                            <!--template bindings={}-->
                                                            <li> <span class="field">Valid on: </span> <span class="value">All Days</span> </li>
                                                            <!--template bindings={}-->
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="flt-right txt-center">
                                                            <!--template bindings={}--> <!--template bindings={}-->
                                                            <div class="price margin-right-s txt-right">
                                                                <!--template bindings={}-->
                                                                <p class="actual-price"><i aria-hidden="true" class="fa fa-inr"></i> 500</p>
                                                                <p class="txt-brand-secondary discounted-price"><i aria-hidden="true" class="fa fa-inr"></i> 299</p>
                                                            </div>
                                                            <div class="quantity clearfix">
                                                                <div class="input-group">
                                                     <span class="input-group-btn">
                                                     <button type="button" class="quantity-left-minus btn btn-default btn-number"  data-type="minus" data-field="">
                                                     <span class="glyphicon glyphicon-minus"></span>
                                                     </button>
                                                     </span>
                                                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="10" min="1" max="100">
                                                                    <span class="input-group-btn">
                                                     <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                     <span class="glyphicon glyphicon-plus"></span>
                                                     </button>
                                                     </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div class="table">
                                        <div class="table_cell option-list-wrapper show-on-desktop-display-table">
                                            <div class="option_list">2</div>
                                        </div>
                                        <div class="table_cell">
                                            <div class="block_inner">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <p class="option_title txt-primary">Buy 1 Movie Ticket Get 1 Free</p>
                                                        <!--template bindings={}--> <!--template bindings={}-->
                                                        <ul class="option_validity">
                                                            <!--template bindings={}-->
                                                            <li> <span class="field">Valid for: </span> <span class="value">2 Persons</span> </li>
                                                            <!--template bindings={}-->
                                                            <li> <span class="field">Valid on: </span> <span class="value">All Days</span> </li>
                                                            <!--template bindings={}-->
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="flt-right txt-center">
                                                            <!--template bindings={}--> <!--template bindings={}-->
                                                            <div class="price margin-right-s txt-right">
                                                                <!--template bindings={}-->
                                                                <p class="actual-price"><i aria-hidden="true" class="fa fa-inr"></i> 350</p>
                                                                <p class="txt-brand-secondary discounted-price"><i aria-hidden="true" class="fa fa-inr"></i> 200</p>
                                                            </div>
                                                            <div class="quantity clearfix">
                                                                <div class="input-group">
                                                     <span class="input-group-btn">
                                                     <button type="button" class="quantity-left-minus btn btn-default btn-number"  data-type="minus" data-field="">
                                                     <span class="glyphicon glyphicon-minus"></span>
                                                     </button>
                                                     </span>
                                                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="10" min="1" max="100">
                                                                    <span class="input-group-btn">
                                                     <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                     <span class="glyphicon glyphicon-plus"></span>
                                                     </button>
                                                     </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--template bindings={}-->
                            <div class="block block-secondary">
                                <div class="block_inner">
                                    <h4 class="margin-bottom-m font-weight-semibold">How to use offer</h4>
                                    {!! $deal->terms !!}
                                </div>
                            </div>
                            <div class="block block-secondary">
                                <div class="block_inner">
                                    <img alt="" class="promise-img" src="{{ asset("/frontend/images/logo.png") }}"  width="120" height="40">
                                    <p class="promise-content">Your purchase is <b class="txt-primary">100% secured</b> with us </p>
                                </div>
                            </div>
                            <!--template bindings={}-->
                            <div class="block block-secondary">
                                <div class="block_inner">
                                    <h4 class="margin-bottom-m font-weight-semibold">ClubJB Terms</h4>
                                    {!! $deal->club_terms !!}
                                </div>
                            </div>
                            <!--template bindings={}-->
                        </div>
                        <div class="col-md-4">
                            <div class="offer hidden" >
                                <!--template bindings={}-->
                                <div class="block block-secondary">
                                    <div class="block_header txt-center">
                                        <h3 class="font-weight-semibold">Your order</h3>
                                    </div>
                                    <div class="block_inner">
                                        <div class="orders_list">
                                            <!--template bindings={}-->
                                            <div class="margin-bottom-m">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3><i aria-hidden="true" class="fa fa-inr"></i> 300</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="divider">
                                        <div class="orders_total orders_total_empty">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p>Total</p>
                                                    <span class="txt-tertiary font-sm">Inclusive of all taxes</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="flt-right">
                                                        <p class="font-weight-regular"><i aria-hidden="true" class="fa fa-inr"></i> 300</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--template bindings={}--> <button class="order-total-fix btn btn-primary btn-block font-weight-semibold">Buy now </button>
                                    </div>
                                    <div class="orders_savings txt-center">
                                        <p class="txt-secondary font-size-xs">you are saving <i aria-hidden="true" class="fa fa-inr margin-reset"></i> <b>500</b></p>
                                    </div>
                                </div>
                                <!--template bindings={}--> <!--template bindings={}-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection