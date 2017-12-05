@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>

            <li class="active">
                <span class="fa fa-map-marker"></span> Bonus Deal
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">


                    @if(authority_match(\App\User::$admin))
                        <form class="row" method="post" action="{{ route('bonusdeal.store') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Enter Bonus Title</label>
                                    <input class="form-control" name="title" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="welcome">Welcome Bonus</option>
                                        <option value="referral">Referral Bonus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     <label>Term And Conditions </label>
                                     <textarea class="form-control"  rows="4" name="term_n_condition" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <br/>
                                    <button class="btn btn-primary"><i class="fa fa-globe"></i> Add Bonus Coupon
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <h2>Bonus Deal</h2>
                    @endif
                </div>

                <div class="panel-body">
                    @include('admin.bonusdeal.table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var metaDescCK;
        $(function () {
            metaDescCK = $("textarea[name='term_n_condition']").ckeditor();
        });
    </script>
@append