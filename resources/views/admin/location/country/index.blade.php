@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>

            <li class="active">
                <span class="fa fa-globe"></span> Countries
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Countries</h2>
                    @if(authority_match(\App\User::$admin))
                        @include("admin.location.country.form", [
                            "route_name" => "country_add",
                            "route_method" => "post",
                        ])
                    @endif
                </div>

                <div class="panel-body">
                    @include('admin.location.country.table')
                    @include('admin.location.country.edit')
                </div>
            </div>
        </div>
    </div>
@endsection