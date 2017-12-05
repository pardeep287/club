@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('booklet') }}"><span class="fa fa-book"></span> Booklets</a></li>
            <li class="active"><span class="fa fa-money"></span> Purchase</li>
        </ol>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h3 class="page-title">Customer Care Booklet Purchase</h3>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Get Booklet code</h5>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('bookletpurchase') }}" class="form" method="post">
                            {{ csrf_field() }}
                            <fieldset class="col-md-3">
                                <label for="mobile" class="form-controllabel">Mobile Number</label>
                                <input type="phone" class="form-control" placeholder="mobile" name="mobile"
                                       id="customer-mobile" value="{{ old('mobile') }}">
                            </fieldset>
                            <fieldset class="col-md-3">
                                <label for="booklet" class="form-controllabel">Booklet Desired</label>
                                <select name="booklet" id="customer-booklet" class="form-control">
                                    @foreach(App\Booklet::all()->groupBy('city_id') as $city_id => $booklets)
                                        <optgroup label="{{ App\City::find($city_id)->name }}">
                                            @foreach($booklets as $booklet)
                                                <option value="{{ $booklet->id }}" {{ (old('booklet') === $booklet->id) ? 'selected' : '' }} > {{ $booklet->name }}
                                                    (Available: {{ $booklet->codesLeft() }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </fieldset>

                            <fieldset class="col-md-3">
                                <label for="customer-transaction" class="form-controllabel">Remarks</label>
                                <input type="text" class="form-control" value="{{ old('remarks') }}" name="remarks">
                            </fieldset>

                            <fieldset class="col-md-3">
                                <label for="customer-transaction" class="form-controllabel"> Get Code</label>
                                <br>
                                <button class="btn btn-primary">
                                    <span class="fa fa-qrcode"></span> <strong>Go</strong> <span
                                            class="fa fa-qrcode"></span>
                                </button>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Client Overview</div>
                <div class="panel-body">
                    @if(session('code'))
                        <div class="alert alert-success">
                            You have successfully been assigned a code <em>#{{session('code.id')}}</em>
                            <strong>{{ session('code.code') }}</strong> valid till
                            <em>{{ session('code.end') }}</em>.
                        </div>
                    @endif
                    @if(session('booklet'))
                        <div class="alert alert-info">
                            The code can be redeemed to add booklet
                            <strong>{{ '#' . session('booklet.id') . ' => ' . session('booklet.name') }}</strong> to
                            customer's account before code expires.
                        </div>
                    @endif
                    @if(session('transaction'))
                        <div class="alert alert-warning">
                            Remember Transaction id <strong>#{{ session('transaction.id') }}</strong> for future
                            references.
                        </div>
                    @endif

                    @if(authority_match('admin'))
                        @include('admin.care.booklet.table')
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!--/.row-->
@endsection