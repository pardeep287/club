@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li class="active"><span class="fa fa-tag"></span> Deals</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="fa fa-exclamation-triangle"></i>
                    Endangered Deals
                    <i class="fa fa-exclamation-triangle"></i>
                </div>

                <div class="panel-body">
                    @include('admin.deal.table', ['table_data_route' => "datatables.deal.endangered"])
                </div>
            </div>
        </div>
    </div>
@endsection