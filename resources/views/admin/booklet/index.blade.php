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

                @if(authority_match(\App\User::$admin) && isset($city))
                    <h2>{{ $city->name }}</h2>
                    <form class="row" method="post" action="{{ route('booklet_add') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enter Booklet Name</label>
                                <input name="city_id" type="hidden" value="{{ $city->id }}">
                                <input class="form-control" name="name" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Booklet Image</label>
                                <input class="form-control" name="avatar" type="file" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" name="price" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Validity <small>(in Days)</small></label>
                                <input class="form-control" name="validity" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <br/>
                                <button class="btn btn-primary"><i class="fa fa-plus"></i> Add Booklet</button>
                            </div>
                        </div>
                    </form>
                @else
                    <h2>Booklets</h2>
                @endif
            </div>

            <div class="panel-body">
                @include('admin.booklet.table')
            </div>
        </div>
    </div>
</div>
@endsection