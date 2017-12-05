@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-barcode">  Booklets</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>{{ $booklet->name }}</h2>
            </div>
            <div class="panel-body">
                @include('admin.deal.table')
            </div>
        </div>
    </div>
</div>
@endsection