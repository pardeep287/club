@extends('layouts.app')
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li class="active"><span class="fa fa-dashboard"></span> Dashboard</li>
        </ol>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <a href="{{ route('client') }}">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <em class="fa fa-user-secret fa-4x"></em>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{ App\Client::where('client_type', 'android')->count() }}</div>
                            <div class="text-muted">Total Customers</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <a href="{{ route('deal') }}">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <em class="fa fa-tags fa-4x"></em>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{ App\Deal::all()->count() }}</div>
                            <div class="text-muted">Total Deals</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <a href="{{route('store')}}">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <em class="fa fa-building fa-4x"></em>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{ App\Store::all()->count() }}</div>
                            <div class="text-muted">Total Store</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <a href="{{ route('user') }}">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <em class="fa fa-users fa-4x"></em>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{ App\User::all()->count() }}</div>
                            <div class="text-muted">Total Executive</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--/.row-->
    @if(false)
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Overview</div>
                    <div class="panel-body">
                        <div class="canvas-wrapper2222">
                            <!--<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>-->
                            <div class="col-md-6">
                                <h3>Clients</h3>
                                <hr>
                                <div class="col-md-12">
                                    @include('admin.client.table')
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3>Stores</h3>
                                <hr>
                                <div class="col-md-12">
                                    @include('admin.store.table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->
    @else
        <article class="row">
            <div class="col-md-12">
                <h4>Additional Details</h4>
                <p>
                    Select one from Side Bar to begin.
                </p>
            </div>
        </article>
    @endif
@endsection