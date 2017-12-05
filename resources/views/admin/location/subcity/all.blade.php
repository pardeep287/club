@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active">
            <span class="fa fa-map-marker"></span> SubCities
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Sub Cities</h2>
                @if(authority_match(\App\User::$admin))
                <form class="row" method="post" action="{{ route('add_new_subcity') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="col-md-4">
                            @include('layouts.select.country')
                        </div>
                        <div class="col-md-4">
                            @include('layouts.select.state')
                        </div>
                        <div class="col-md-4">
                            @include('layouts.select.city')
                        </div>

                        @section('scripts')
                            <script src="{{ asset('/js/lakshay.js') }}"></script>
                        @append
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-controllabel">Enter Sub City Name</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-controllabel">Create New Sub City</label>
                            <button class="btn btn-primary"><i class="fa fa-globe"></i> Add Subcity</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>

            <div class="panel-body">
                @include('admin.location.subcity.table')
            </div>
        </div>
    </div>
</div>
@endsection