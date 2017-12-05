<div class="modal fade" id="defaultvalue-edit" tabindex="-1" role="dialog" aria-labelledby="defaultvalue-editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="defaultvalue-editLabel">
                    Edit Defaults
                </h4>
            </div>
            <div class="modal-body">
                @include('admin.default.form',['formaction'=>"value_edit", 'formmethod' => 'patch', 'modal' => true])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Edit Pair</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $('#defaultvalue-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var defaultID = button.data('id');
        var defaultKey = button.data('key');
        var defaultValue = button.data('value');
        var title = "Edit " + defaultKey; // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(defaultID);
        modal.find(".modal-body input[name='key']").val(defaultKey);
        var textarea = modal.find(".modal-body textarea[name='value']");
        textarea.ckeditor();
        textarea.val(defaultValue);
        if(defaultID <= 8){
            modal.find(".modal-body input[name='key']").prop('readonly', true);
        }else{
            modal.find(".modal-body input[name='key']").prop('readonly', false);
        }
    });

    $("#defaultvalue-edit button.submit").on('click', function (event) {
        $("#defaultvalue-edit form").submit();
    });
</script>
@append
</div>