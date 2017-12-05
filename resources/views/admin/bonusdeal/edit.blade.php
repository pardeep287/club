<div class="modal fade" id="bonusdeal-edit" tabindex="-1" role="dialog" aria-labelledby="city-editLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="city-editLabel">
                    Edit Store
                </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('bonusdeal.update',[5]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="name" class="form-control-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-control-label">
                            Active
                            <input type="checkbox" class="form-control" name="status" required>
                        </label>
                    </div>
                    <div class="form-group">
                        <lable class="form-control-label">Type</lable>
                        <select name="type" id="type" class="form-control">
                            <option value="welcome">Welcome Bonus</option>
                            <option value="referral">Referral Bonus</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable class="form-control-label">Term And Conditions </lable>
                        <textarea class="form-control" rows="6" id="term_n_condition"  name="term_n_condition" required></textarea>
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

        var metaDescCK;
        $(function () {
            metaDescCK = $("textarea[name='term_n_condition']").ckeditor();
        });
        $('#bonusdeal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var bdid = button.data('id');
            var title = button.data('title');
            var type = button.data('type');
            var term_n_condition = button.data('term_n_condition');
            var faction = button.data('action');
            var model_title = "Edit " + title; // Extract info from data-* attributes
            var modal = $(this);
            modal.find('.modal-title').text(model_title);
            modal.find(".modal-body form").attr('action', faction);
            modal.find(".modal-body input[name='id']").val(bdid);
            modal.find(".modal-body input[name='title']").val(title);
            modal.find(".modal-body select[name='type']").val(type);
            modal.find(".modal-body textarea[name='term_n_condition']").val(term_n_condition);

            if (button.data('status')) {
                modal.find(".modal-body input[name='status']").prop('checked', true);
            } else {
                modal.find(".modal-body input[name='status']").prop('checked', false);
            }

        });

        $("#bonusdeal-edit button.submit").on('click', function (event) {
            $("#bonusdeal-edit form").submit();
        });
    </script>
@append

