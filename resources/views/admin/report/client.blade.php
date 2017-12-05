@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li><a href="{{ route('report') }}"><span class="fa fa-flag"></span> Reports</a></li>
        <li class="active"><span class="fa fa-user"></span> Clients</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Reports</h1>
            </div>

            <div class="panel-body">
                @include('admin.report.client_table')
            </div>
        </div>
    </div>
</div>
@endsection