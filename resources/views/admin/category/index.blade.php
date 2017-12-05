@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active">
            <span class="fa fa-user"></span> Category
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Categories</h2>

                        <div class="row">
                            @if(authority_match(\App\User::$admin))
                                @include('admin.category.form',['form'=> ['route' => 'category_add', 'method' => 'post', 'handlesubmit' => false]])
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                @include('admin.category.table')
            </div>
        </div>
    </div>
</div>
@endsection