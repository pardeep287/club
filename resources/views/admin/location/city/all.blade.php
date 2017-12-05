@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active">
            <span class="fa fa-map-marker"></span> Cities
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <h2>Cities</h2>

                @if(authority_match(\App\User::$admin))
                <form class="row" method="post" action="{{ route('add_new_city') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-3">
                        @include('layouts.select.country')
                    </div>
                    <div class="col-md-3">
                        @include('layouts.select.state')
                    </div>
                    @section('scripts')
                        <script src="{{ asset('/js/lakshay.js') }}"></script>
                    @append
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Enter City Name</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <br/>
                            <button class="btn btn-primary"><i class="fa fa-globe"></i> Add City</button>
                        </div>
                    </div>
                </form>
                @else
                <h2>Cities</h2>
                @endif
            </div>

            <div class="panel-body">
                @include('admin.location.city.table')
            </div>
        </div>
    </div>
</div>
@endsection