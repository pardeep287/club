@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-user"></span> Users</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(authority_match(\App\User::$admin))
                    <form class="row" method="post" action="{{ route('user_add') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Enter Name</label>
                                <input class="form-control" name="name" type="text" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Enter Mobile</label>
                                <input class="form-control" name="mobile" type="phone" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Enter Email</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>User Avatar</label>
                                <input class="form-control" name="avatar" type="file" accept="image\*" value="{{ old('avatar') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Auth Level</label>
                                <select class="form-control" name="auth_level">
                                    <option value="executive">Executive</option>
                                    <option value="care">Customer Care</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Enter Password</label>
                                <input class="form-control" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Re-enter Password</label>
                                <input class="form-control" name="password_confirmation" type="password">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <br/>
                                <button class="btn btn-primary"><i class="fa fa-plus"></i> Add User</button>
                            </div>
                        </div>
                    </form>
                @else
                    <h2>Users</h2>
                @endif
            </div>

            <div class="panel-body">
                @include('admin.user.table')

                @if(authority_match(\App\User::$admin))
                    @include('admin.user.edit')
                @endif
            </div>
        </div>
    </div>
</div>
@endsection