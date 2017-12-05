@extends('layouts.app') @section('content')
<div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
        <li class="active"><span class="fa fa-building">  Stores</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Stores</h2>
            </div>

            <div class="panel-body">
                @if(authority_match(\App\User::$admin))
                    <div id="store-new" class="col-md-12">
                        <button class="btn btn-primary pull-right" onclick="formToggleForStore()">
                            <span class="fa fa-times"></span> <span> Close Form</span>
                        </button>
                        @section('scripts')
                        <script>
                            function formToggleForStore()
                            {
                                var form = $('#store-new form');
                                var button = $('#store-new button.btn-primary');
                                form.toggle();

                                if(form.is(':visible')){
                                    button.find("span:nth-child(1)").removeClass("fa fa-plus");
                                    button.find("span:nth-child(1)").addClass("fa fa-times");
                                    button.find("span:nth-child(2)").text("Close Form");
                                }else{
                                    button.find("span:nth-child(1)").removeClass("fa fa-times");
                                    button.find("span:nth-child(1)").addClass("fa fa-plus");
                                    button.find("span:nth-child(2)").text("Add Store Form");
                                }
                            }

                            $(formToggleForStore());
                 
                            $(document).ready(function(){
                                        $("#store-new textarea[name='terms']").ckeditor();

                            });
                        </script>
                        @append

                        <div class="row">
                        @include('admin.store.form',['form' => ['route' => 'store_add', 'method' => 'post', 'handlesubmit' => false]])
                        </div>
                    </div>
                    <hr>
                    <hr>
                @endif
                @include('admin.store.table')
            </div>
        </div>
    </div>
</div>
@endsection