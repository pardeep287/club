<div>
    <div class="row">
        <div class="col-md-10">
            <h3>{{$client->name}}</h3>
            <small>
                <ul>
                    <li>
                        <strong>Mobile:</strong> <em>{{$client->mobile}}</em>
                    </li>
                    <li>
                        <strong>Email:</strong> {{$client->email}}
                    </li>
                    <li>
                        <strong>Address:</strong> {{$client->address}}
                    </li>
                </ul>
            </small>
        </div>

        @if(authority_match(\App\User::$admin))
            <div class="col-md-2">
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#client-edit" type="button" onclick="edit_user()">
                    <span class="fa fa-edit"></span> Edit
                </button>
            </div>
            <div class="modal fade" id="client-edit" tabindex="-1" role="dialog" aria-labelledby="client-editLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="client-editLabel">
                                Edit Client Details
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form class="row" method="post" action="{{ route('client_edit') }}">
                                {{ csrf_field() }} {!! method_field('patch') !!}
                                <input name="id" type="hidden" value="{{ $client->id }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input class="form-control" name="name" type="text" value="{{ $client->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Enter Email</label>
                                        <input class="form-control" name="email" type="email" value="{{ $client->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input class="form-control" name="mobile" type="text" value="{{ $client->mobile }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" cols="30" rows="6" class="form-control">{{ $client->address }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary submit">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    @section('scripts')
    <script>
        $('#client-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this);
        });

        $("#client-edit button.submit").on('click', function (event) {
            $("#client-edit form").submit();
        });
    </script>
    @append
</div>