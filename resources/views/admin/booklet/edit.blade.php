<div class="modal fade" id="booklet-edit" tabindex="-1" role="dialog" aria-labelledby="booklet-editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="booklet-editLabel">
                    Booklet Editing
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('booklet_edit') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input type="hidden" name="id">
                    <input type="hidden" name="city_id">

                    <div class="form-group">
                        <label for="name" class="form-control-label">Booklet Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="avatar" class="form-control-label">Booklet Image</label>
                        <label>Booklet Image</label>
                        <input class="form-control" name="avatar" type="file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-control-label">Price:</label>
                        <input class="form-control" type="number" name="price" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="validity" class="form-control-label">Validity:</label>
                        <input class="form-control" type="number" name="validity" required min="0">
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
    $('#booklet-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var bookletID = button.data('id');
        var bookletCity = button.data('city');        
        var bookletName = button.data('name');
        var title = "Edit " + bookletName; // Extract info from data-* attributes
        var bookletPrice = button.data('price');
        var bookletValidity = button.data('validity');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(bookletID);
        modal.find(".modal-body input[name='city_id']").val(bookletCity);
        modal.find(".modal-body input[name='name']").val(bookletName);
        modal.find(".modal-body input[name='price']").val(bookletPrice);
        modal.find(".modal-body input[name='validity']").val(bookletValidity);
    });

    $("#booklet-edit button.submit").on('click', function (event) {
        $("#booklet-edit form").submit();
    });
</script>
@append