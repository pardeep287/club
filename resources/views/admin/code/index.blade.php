@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('booklet') }}"><span class="fa fa-book"></span> Booklets</a></li>
            <li class="active"><span class="fa fa-barcode">  Codes</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    {{ $booklet->name . ', ' . $booklet->city->name }}

                    @if(authority_match(\App\User::$admin))
                        <form class="row" method="post" action="{{ route('code_create', $booklet->id) }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" name="quantity" type="number" min="1" value="10"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Method</label>
                                    <select name="method" class="form-control">
                                        <option value="random">Random</option>
                                        <option value="simple">Simple</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Length</label>
                                    <input class="form-control" name="length" type="number" min="3" value="3" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input class="form-control" name="value" type="text" min="3"
                                           value="{{ old('value') }}" required
                                           placeholder="Incase of Random, this will be treated as Prefix">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Validity
                                        <small>(in Days)</small>
                                    </label>
                                    <input class="form-control" name="validity" type="number" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <br/>
                                    <button class="btn btn-primary"><i class="fa fa-plus"></i> Create New Codes</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <h2>Codes</h2>
                    @endif
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-danger text-center">
                                <strong>{{ $booklet->codes()->expired(['created'])->count() }}</strong>
                                have expired and not sold hence should be reused.
                            </h4>

                            <form action="{{ route("code.expired.handle", $booklet) }}" class="col-md-12" method="post">
                                {!! csrf_field() !!}
                                <div class="col-md-4">
                                    <select name="handle" id="handler" class="form-control">
                                        <option value="pause">Pause Codes</option>
                                        <option value="extend">Extend the expiry</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input type="text" name="days" placeholder="Number of days starting today"
                                           class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" checked name="include-paused">
                                            Include Paused Coupons
                                            (+ {{ $booklet->codes()->expired(['paused'])->count() }})
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input type="submit" value="Handle" class="btn btn-info btn-block">
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.code.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection