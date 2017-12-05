@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li><a href="{{ route('country') }}"><span class="fa fa-globe"></span> Countries ({{ $country->name }}) </a></li>
        <li>
            <a href="{{ route('state', $country->id) }}"> <span class="fa fa-globe"></span> {{ $state->name }} </a>
        </li>
        <li class="active">
            <span class="fa fa-map-marker"></span> City
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <h2>{{ $state->name }}</h2>

                @if(authority_match(\App\User::$admin))
                    <form class="row" method="post" action="{{ route('city_add', [$country, $state]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-4">
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