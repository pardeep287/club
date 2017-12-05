@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li><a href="{{ route('booklet') }}"><span class="fa fa-book"></span> Booklets</a></li>
        <li class="active"> <span class="fa fa-tag"></span> Deals</li>
    </ol>
</div>
<!--/.row-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $booklet->name }}</h1>
    </div>
</div>
<!--/.row-->
<div class="row create-booklet">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel-group" id="accordion">

                    @foreach($stores as $store)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{ str_replace(' ', '-', $store->name) }}">
                                    <i class="fa fa-building-o"></i> {{ $store->name }} <small>Deals: {{ $store->deals()->count() }}</small>
                                </a>
                            </h4>
                        </div>
                        <div id="{{ str_replace(' ', '-', $store->name) }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form role="form">
                                    @foreach($store->deals as $deal)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <h4 class="col-md-8">
                                                    <input value="" type="checkbox"> {{ $deal->title }}
                                                </h4>
                                                <div class="col-md-2 no-padding">
                                                    <label>Max Quantity</label>
                                                    <input class="form-control" type="number" placeholder="Quantity" max="{{ $deal->max_daily_limit }}" value="{{ $deal->max_quantity }}">
                                                </div>
                                                <div class="col-md-2 no-padding">
                                                    <label>Daily Limit</label>
                                                    <input class="form-control" type="number" placeholder="Daily Limit" max="{{ $deal->max_daily_limit }}" value="{{ $deal->max_quantity }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr> @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!--/.col-->
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading dark-overlay"><i class="fa fa-book"></i> {{ $booklet->name }}</div>
            <div class="panel-body">
                @foreach($booklet->deals as $deal)
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4 no-padding">
                            <img src="{{ asset($deal->imageAvatar()) }}" alt="{{ $booklet->name }}" class="img-responsive" />
                            <div class="ribbon-wrapper-green">
                                <div class="ribbon-green">{{ $deal->pivot->quantity }} Coupons</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-center font-2x">
                                {{ $deal->title }}
                            </h5>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
                <form role="form" class="margin-top">
                    <div class="row">
                        <div class="col-md-8">
                            <form role="form">
                                <div class="form-group">
                                    <label class="col-md-5">Booklet Price</label>
                                    <div class="price radio col-md-7 no-padding">
                                        <label class="radio-inline"><input type="radio" name="optradio" checked>Paid</label>
                                        <label class="radio-inline"><input type="radio" name="optradio">Free</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-5">
                                    <input class="form-control" type="text">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="price radio col-md-12 no-padding">
                                    <label class="radio-inline"><input type="radio" name="optradio" checked>Active</label>
                                    <label class="radio-inline"><input type="radio" name="optradio">Inactive</label>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#terms-conditions">Terms & Conditions</button>
                    </div>
                    <div class="col-md-8"><button type="submit" class="btn btn-primary pull-right">Create Booklet</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection