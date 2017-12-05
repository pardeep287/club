@if(isset($city->id))
<div class="modal fade" id="city-edit" tabindex="-1" role="dialog" aria-labelledby="city-editLabel" aria-hidden="true">
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
                <form method="post" action="{{ route('city_edit', [$city->state->country, $city->state]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }} {!! method_field('patch') !!}
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <lable class="form-control-label">State</lable>
                        <select name="state_id" class="form-control">
                            @foreach(App\State::all() as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-control-label">City Name</label>
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
    $('#city-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var cityID = button.data('id');
        var cityName = button.data('name');
        var stateID = button.data('state_id');
        var title = "Edit " + cityName; // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find(".modal-body input[name='id']").val(cityID);
        modal.find(".modal-body input[name='name']").val(cityName);
        modal.find(".modal-body select[name='state_id']").val(stateID);
    });

    $("#city-edit button.submit").on('click', function (event) {
        $("#city-edit form").submit();
    });
</script>
@append

@endif