<div class="modal fade" id="{{ $modalid }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalid }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="{{ $modalid }}Label">
                    Edit Store
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="post" action="{{ route($formaction) }}" enctype="multipart/form-data">
                        {{ csrf_field() }} {!! method_field($formmethod) !!}
                        <input type="hidden" name="id">

                        <div class="col-md-6">
                            <div class="form-group"><label>Client Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Client mobile</label>
                                <input type="text" class="form-control" name="mobile" required value="{{ old('mobile') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">City</label>
                                <select name="city_id" class="form-control">
                                    @foreach(App\City::all() as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_type" class="form-control-label">Client Type</label>
                                <select name="client_type" class="form-control">
                                    <option value="android">Android User</option>
                                    <option value="sales">JB Sales Person</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Client Avatar</label>
                                <input class="form-control" name="avatar" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Client email</label>
                                <input type="text" class="form-control" name="email" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Client Address</label>
                                <textarea name="address" cols="30" rows="10" class="form-control">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Submit</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $('#{{ $modalid }}').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var clientID = button.data('id');
        var clientName = button.data('name');
        var clientCity = button.data('city');
        var clientMobile = button.data('mobile');
        var clientEmail = button.data('email');
        var clientAddress = button.data('address');
        var title = "Edit " + clientName; // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(clientID);
        modal.find(".modal-body input[name='name']").val(clientName);
        modal.find(".modal-body input[name='mobile']").val(clientMobile);
        modal.find(".modal-body input[name='email']").val(clientEmail);
        modal.find(".modal-body textarea[name='address']").val(clientAddress);
        modal.find(".modal-body select[name='city_id']").val(clientCity);
        modal.find(".modal-body select[name='client_type']").val(button.data('client_type'));
    });

    $("#{{ $modalid }} button.submit").on('click', function (event) {
        $("#{{ $modalid }} form").submit();
    });
</script>
@append