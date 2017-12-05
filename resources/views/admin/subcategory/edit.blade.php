<div class="modal fade" id="subcategoryEditModal" tabindex="-1" role="dialog" aria-labelledby="subcategoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="subcategoryEditModalLabel">
                    Edit
                </h4>
            </div>
            <div class="modal-body">
                @include('admin.subcategory.form',['form' => ['route' => 'subcategory_edit', 'method' => 'patch', 'handlesubmit' => true]])
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
  $('#subcategoryEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var modal = $(this);



    console.log('opening model');
    modal.find('.modal-title').text("Edit " + button.data('name'));
    modal.find(".modal-body input[name='id']").val(button.data('id'));
    modal.find(".modal-body select[name='category_id']").val(button.data('category_id'));
    modal.find(".modal-body input[name='name']").val(button.data('name'));
    modal.find(".modal-body textarea[name='description']").val(button.data('description'));
    console.log(button.data('name'));
    console.log('model open');
  });

  $("#subcategoryEditModal button.submit").on('click', function(event) {
    $("#subcategoryEditModal form").submit();
  });
</script>
@append