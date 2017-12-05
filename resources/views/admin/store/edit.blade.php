<div class="modal fade" id="store-edit" tabindex="-1" role="dialog" aria-labelledby="store-editLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="store-editLabel">
                    Edit Store
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    @include('admin.store.form',['form' => ['route' => 'store_edit', 'method' => 'patch', 'handlesubmit' => true]])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Edit</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/js/ckeditor/adapters/jquery.js') }}"></script>
@append


@section('scripts')
    <script>
        $('#store-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this);
            modal.find('.modal-title').text("Edit " + button.data('name'));
            modal.find(".modal-body input[name='id']").val(button.data('id'));
            modal.find(".modal-body input[name='name']").val(button.data('name'));

            modal.find(".modal-body input[name='mobile']").val(button.data('mobile'));
            modal.find(".modal-body input[name='pincode']").val(button.data('pincode'));

            if (button.data('address_1') != ".") {
                modal.find(".modal-body input[name='address_1']").val(button.data('address_1'));
                modal.find(".modal-body input[name='address_2']").val(button.data('address_2'));
                modal.find(".modal-body input[name='address_3']").val(button.data('address_3'));
            } else {
                modal.find(".modal-body input[name='address_1']").val(button.data('address'));
            }

            if (button.data('terms')) {
                modal.find(".modal-body textarea[name='terms']").val(button.data('terms'));
                $("#store-edit .modal-body textarea[name='terms']").ckeditor();
            }

            handleCheckbox(modal, button, 'active');
            handleCheckbox(modal, button, 'top_pick');
            handleCheckbox(modal, button, 'trusted');
            handleCheckbox(modal, button, 'preferred');

            modal.find(".modal-body select[name='city_id']").val(button.data('city_id'));
            modal.find(".modal-body select[name='city_id']").trigger("change");

            modal.find(".modal-body input[name='latitude']").val(button.data('latitude'));
            modal.find(".modal-body input[name='longitude']").val(button.data('longitude'));
            modal.find(".modal-body select[name='categories[]']").val(button.data('storecategories'));

            modal.find(".modal-body select[name='membership']").val(button.data('membership'));
        });

        function handleCheckbox(modal, button, checkbox) {
            modal.find(".modal-body input[name='" + checkbox + "']").val(button.data(checkbox));
            if (button.data(checkbox)) {
                modal.find(".modal-body input[name='" + checkbox + "']").prop('checked', true);
            } else {
                modal.find(".modal-body input[name='" + checkbox + "']").prop('checked', false);
            }
        }


        $("#store-edit button.submit").on('click', function (event) {
            $("#store-edit form").submit();
        });
    </script>
@append