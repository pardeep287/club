<div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="categoryEditModalLabel">
                    Edit
                </h4>
            </div>
            <div class="modal-body">
                @include('admin.category.form',['form' => ['route' => 'category_edit', 'method' => 'patch', 'handlesubmit' => true]])
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
  $('#categoryEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var modal = $(this);
    modal.find('.modal-title').text("Edit " + button.data('name'));
    modal.find(".modal-body input[name='id']").val(button.data('id'));
    modal.find(".modal-body input[name='name']").val(button.data('name'));
    modal.find(".modal-body textarea[name='description']").val(button.data('description'));
  });

  $("#categoryEditModal button.submit").on('click', function(event) {
    $("#categoryEditModal form").submit();
  });
</script>
@append