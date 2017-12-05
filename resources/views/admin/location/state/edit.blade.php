<div class="modal fade" id="state-edit" tabindex="-1" role="dialog" aria-labelledby="state-editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="state-editLabel">
                    Edit Store
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('state_edit', $state->country->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="name" class="form-control-label">State Name</label>
                        <input type="text" class="form-control" name="name" required>
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
    $('#state-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var stateID = button.data('id');
        var stateName = button.data('name');
        var title = "Edit " + stateName; // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(stateID);
        modal.find(".modal-body input[name='name']").val(stateName);
    });

    $("#state-edit button.submit").on('click', function (event) {
        $("#state-edit form").submit();
    });
</script>
@append