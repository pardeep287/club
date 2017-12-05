@extends('layouts.app')
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('deal') }}"><span class="fa fa-tags"></span> Deals</a></li>

            <li class="active"><span class="fa fa-tag"></span> Deals</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <h2 class="col-md-12">Advertisements</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('advertisment_add') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="col-md-4">
                                    @include('layouts.select.city')
                                </div>

                                <div class="col-md-4">
                                    <label for="avatar">Image</label>
                                    <input name="avatar" type="file" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-2">
                                    <label for="order">Order</label>
                                    <input name="order" type="number" class="form-control"
                                           value="{{ (null !== old('value')) ? old('value') : ($advertisments->count() + 1) }}">
                                </div>
                                <div class="col-md-2 pull-right">
                                    <label for="submit">Create advert</label>
                                    <button name="submit" class="form-control btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-stripped" id="advertisement-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>City</th>
                            <th>Image</th>
                            <th>Order</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($advertisments as $advertisment)
                            <tr id="advert-{{ $advertisment->id }}">
                                <td class="advertID">{{ $advertisment->id }}</td>
                                <td class="advertID">{{ $advertisment->city->name }}</td>
                                <td class="advertImg"><img src="{{ $advertisment->imageAvatar() }}" alt="JB Advert"
                                                           class="img img-thumbnail"></td>
                                <td class="advertOrder">{{ $advertisment->ord }}</td>
                                <td>
                                    <button data-id="{{ $advertisment->id }}" data-order="{{ $advertisment->ord }}"
                                            data-active="{{ $advertisment->active }}"
                                            class="btn btn-sm btn-{{ ($advertisment->active) ? 'success' : 'danger' }}"
                                            onclick="changeStatus(this)">
                                        {{ ($advertisment->active) ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    @section('scripts')
                        <script>
                            var advertEdit = "{{ route('advertisment_edit') }}";

                            function changeStatus(element) {
                                var button = $(element);
                                var cstatus = button.data('active');
                                if(cstatus==1){ var msg = 'Inactive';var stchan=false;}else{var msg = 'Active'; var stchan=true;}
                                var active = confirm('Advertisment '+msg+' in application?');
                                var id = button.data('id');
                               // alert(cstatus);
                                stchan
                               if(active){
                                   $.post(advertEdit, {
                                        'id': id,
                                        'active': stchan
                                    }, function (response) {

                                        active = response.active;
                                        button.data('active', active);

                                        if (active) {
                                            button.removeClass('btn-danger');
                                            button.addClass('btn-success');
                                            button.html('Active');
                                        } else {
                                            button.removeClass('btn-success');
                                            button.addClass('btn-danger');
                                            button.html('Inactive');
                                        }

                                    });
                               }
                            }
                        </script>
                        <script>
                            var advertismentTable = $("#advertisement-table");
                            $(initialiseDataTable(advertismentTable));
                        </script>
                    @append
                </div>
            </div>
        </div>
    </div>
@endsection