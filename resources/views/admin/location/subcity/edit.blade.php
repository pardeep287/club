@if(isset($subcity))

<div class="modal fade" id="subcity-edit" tabindex="-1" role="dialog" aria-labelledby="subcity-editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="subcity-editLabel">
                    Edit Sub City
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('subcity_edit', [$subcity->city->state->country, $subcity->city->state, $subcity->city]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="name" class="form-control-label">Country Name</label>
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
    $('#subcity-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var objectID = button.data('id');
        var objectName = button.data('name');
        var title = "Edit " + objectName; // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(objectID);
        modal.find(".modal-body input[name='name']").val(objectName);
    });

    $("#subcity-edit button.submit").on('click', function (event) {
        $("#subcity-edit form").submit();
    });
</script>
@append

@endif