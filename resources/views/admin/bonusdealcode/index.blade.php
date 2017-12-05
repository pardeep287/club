@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>

            <li class="active">
                <span class="fa fa-map-marker"></span> Bonus Deal Code
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">


                    @if(authority_match(\App\User::$admin))
                        <form action="{{ route('bonusdealcode.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="bonuscode_id" value="{{ $id }}">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input class="form-control" type="number" name="quantity"
                                           value="{{ (null !== old('quantity')) ? old('quantity') : 10 }}">
                                </div>
                            </div>


                            <div class="col-md-5" id="generateFields">


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="length">Length</label>
                                        <input class="form-control" type="number" name="length"
                                               value="{{ (null !== old('length')) ? old('length') : 4 }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="value">Prefix/Value</label>
                                        <input class="form-control" type="text" name="value"
                                               value="{{ (null !== old('value')) ? old('value') : '' }}">
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="value">Master Code</label>
                                    <input class="form-control" type="text" name="master_code"
                                           value="{{ (null !== old('master_code')) ? old('master_code') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="validity">Validity</label>
                                    <input class="form-control" type="number" name="validity"
                                           value="{{ (null !== old('validity')) ? old('validity') : 30 }}">
                                </div>
                            </div>

                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label for="submit">Create more coupons</label>
                                    <button class="btn btn-primary btn-block">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <h2>Bonus Deal</h2>
                    @endif
                </div>

                <div class="panel-body">
                    @include('admin.bonusdealcode.table')
                </div>
            </div>
        </div>
    </div>
@endsection