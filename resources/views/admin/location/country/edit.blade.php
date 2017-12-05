<div class="modal fade" id="country-edit" tabindex="-1" role="dialog" aria-labelledby="country-editLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="country-editLabel">
                    Edit Country
                </h4>
            </div>
            <div class="modal-body">
                @include("admin.location.country.form", [
                    "route_name" => "country_edit",
                    "route_method" => "patch",
                ])
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
        $('#country-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            var title = "Edit " + button.data('name'); // Extract info from data-* attributes
            var modal = $(this);

            modal.find('.modal-title').text(title);
            modal.find(".modal-body input[name='id']").val(button.data('id'));
            modal.find(".modal-body input[name='name']").val(button.data('name'));
            modal.find(".modal-body input[name='short_name']").val(button.data('short_name'));
            modal.find(".modal-body input[name='locale']").val(button.data('locale'));
            modal.find(".modal-body input[name='currency_name']").val(button.data('currency_name'));
            modal.find(".modal-body input[name='currency_code']").val(button.data('currency_code'));
            modal.find(".modal-body input[name='mobile_prefix']").val(button.data('mobile_prefix'));
        });

        $("#country-edit button.submit").on('click', function (event) {
            $("#country-edit form").submit();
        });
    </script>
@append