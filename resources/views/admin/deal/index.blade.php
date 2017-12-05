@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-tag"></span> Deals</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        @if(isset($store->name))
                        <h3>
                            {{ $store->name }}
                        </h3>
                            <small>{!! $store->formatted_address() !!}</small>
                        @else
                        <h3>
                            All Deals
                        </h3>

                            <div class="btn-group">
                                <a class="btn btn-warning" href="{{ route('deal.expired.get') }}">
                                    <i class="fa fa-exclamation"></i> Expired Deals {{ App\Deal::expired()->count() }}
                                </a>
                                <a class="btn btn-danger" href="{{ route('deal.endangered') }}">
                                    <i class="fa fa-exclamation"></i> Endangered
                                    Deals {{ App\Deal::couponCount(null, "<=")->count() }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="panel-body">
                @include('admin.deal.table', ['table_data_route' => 'datatables.dealData'])
            </div>
        </div>
    </div>
</div>
@endsection