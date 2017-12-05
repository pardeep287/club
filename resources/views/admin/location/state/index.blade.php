@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li>
            <a href="{{ route('country') }}"> <span class="fa fa-globe"></span> Countries </a>
        </li>
        <li class="active">
            <span class="fa fa-globe"></span> States in {{ $country->name }}
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <h2>{{ $country->name }} States</h2>

                @if(authority_match(\App\User::$admin))
                    <form class="row" method="post" action="{{ route('state_add', $country->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Enter State Name</label>
                                <input class="form-control" name="name" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <br/>
                                <button class="btn btn-primary"><i class="fa fa-globe"></i> Add State</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            <div class="panel-body">
                @include('admin.location.state.table')
            </div>
        </div>
    </div>
</div>
@endsection