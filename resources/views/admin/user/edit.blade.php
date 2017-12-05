<div class="modal fade" id="user-edit" tabindex="-1" role="dialog" aria-labelledby="user-editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="user-editLabel">New message</h4>
            </div>
            <div class="modal-body">
                <form class="row" method="post" action="{{ route('user_edit') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input name="id" type="hidden">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Enter Name</label>
                            <input class="form-control" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input class="form-control" name="email" type="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Mobile</label>
                            <input class="form-control" name="mobile" type="phone">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Avatar</label>
                            <input class="form-control" name="avatar" type="file" accept="image\*">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Auth Level</label>
                            <select class="form-control" name="auth_level">
                                <option value="executive">Executive</option>
                                <option value="care">Customer Care</option>
                                <option value="admin">Admin</option>
                            </select>
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

@section('scripts')
<script>
    $('#user-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var userID = button.data('id');
        var userName = button.data('name');
        var title = "Edit " + userName; // Extract info from data-* attributes
        var userEmail = button.data('email');
        var auth_level = button.data('auth');
        var userMobile = button.data('mobile');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(userID);
        modal.find(".modal-body input[name='name']").val(userName);
        modal.find(".modal-body input[name='email']").val(userEmail);
        modal.find(".modal-body input[name='mobile']").val(userMobile);
        modal.find(".modal-body select[name='auth_level']").val(auth_level);

    });

    $("#user-edit button.submit").on('click', function (event) {
        $("#user-edit form").submit();
    });
</script>
@append