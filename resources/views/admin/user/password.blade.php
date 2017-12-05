<div class="modal fade" id="edit-lk" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Change Password</h4>
            </div>

            <form class="modal-body" action="{{ route('password_change') }}" method="post">

                <div>
                    {{ csrf_field() }} {!! method_field('patch') !!}
                
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" required class="form-control" name="old_password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" required class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Re enterpassword</label>
                        <input type="password" required class="form-control" name="password_confirmation">
                    </div>
                
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Change
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>