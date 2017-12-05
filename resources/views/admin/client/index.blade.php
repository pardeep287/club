@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li class="active">
                <span class="fa fa-user"></span> Clients
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Clients</h2>

                            @if(false && authority_match(\App\User::$admin))
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal"
                                            data-target="#client-add">
                                        <span class="fa fa-plus"></span> Add Client
                                    </button>
                                    @include('admin.client.modal',['modalid' => 'client-add' ,'formaction'=>'client_add','formmethod'=> 'post'])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('admin.client.table')
                </div>
            </div>
        </div>
    </div>
@endsection