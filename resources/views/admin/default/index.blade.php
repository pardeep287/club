@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-cogs"></span> Default Values</li>
    </ol>
</div>
<!--/.row-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Default Values</h2>
                @include('admin.default.form',['formaction'=>"value_add", 'formmethod' => 'post'])
            </div>
            <div class="panel-body">
                <table class="table table-stripped" id="default-value-table">
                    <thead>
                        <tr>
                            <td>Key</td>
                            <td>Value</td>
                            @if(authority_match(\App\User::$admin))
                            <td>Action</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($defaultvalues as $dv)
                        <tr>
                            <td>{{ $dv->key }}</td>
                            <td>{!! $dv->value !!}</td>
                            @if(authority_match(\App\User::$admin))
                            <td>
                                <button type='button' class='btn btn-primary btn-sm' data-target="#defaultvalue-edit" data-toggle="modal" data-id="{{ $dv->id }}"
                                    data-key="{{ $dv->key }}" data-value="{{ $dv->value }}">
                                    <span class="fa fa-edit"></span> Edit
                                </button>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @include('admin.default.edit')
                
        </div>
    </div>
</div>
<!--/.row-->

@endsection

@section('scripts')
<script>
    var defaultValuesTable = $("#default-value-table");
    $(initialiseDataTable(defaultValuesTable));
</script>
@append