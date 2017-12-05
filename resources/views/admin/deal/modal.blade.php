<div class="modal fade" id="{{ $formid }}">
    <div class="modal-dialog modal-lg">
        <form action="{{ route($formroute) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }} {!! method_field($formrequest) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-tag"></i> {{ strtoupper(str_replace('-', ' ', $formid)) }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Store</label>
                                <select class="form-control" name="store_id">
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" @if ($store->id === $selected_store)
                                            'selected' @endif>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group"><label>Deal Title</label>
                                <input type="text" class="form-control" name="title" required
                                       value="{{ old('title') }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input class="form-control" name="avatar" type="file" accept="image\*">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label>Quantity</label>
                                <input type="number" class="form-control" name="max_quantity" required
                                       value="{{ old('max_quantity') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Max Daily Limit</label>
                                <input type="number" min="1" class="form-control" name="max_daily_limit" required
                                       value="{{ old('max_daily_limit') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Deal Price</label>
                                <input type="number" min="0" class="form-control" name="price" required value="0">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group"><label>Start Date</label>
                                <input type="date" id="deal_begin" class="form-control datepicker" name="begin" required
                                       value="{{ old('begin') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control datepicker" name="end" required
                                       value="{{ old('end') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Deal Type</label>
                                <select name="type" class="form-control">
                                    <option value="normal">Normal Deal</option>
                                    <option value="explicit">Explicit Deal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Number Of Days</label>
                                <input class="form-control" type="number" name="days" min="0" value="0">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                          rows="4">{{ App\DefaultValue::dealDescription()->value }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Terms</label>
                                <textarea class="form-control" name="terms" rows="4">{{ App\DefaultValue::getValue('dealTerms')['value'] }}
                                    &#10;{{ App\DefaultValue::getValue('jbTerms')['value'] }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>

@section('styles')
    <link href="{{ asset('/css/datepicker.css') }}" rel="stylesheet"> @stop

@section('scripts')
    <script src="{{ asset('/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datepicker.js') }}"></script>

    <script>
        $("#{{ $formid }}").on('show.bs.modal', function (event) {
            var modal = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal

            var dealID = button.data('deal');
            var store = button.data('store');
            var dealTitle = button.data('title');
            var title = "Edit " + dealTitle; // Extract info from data-* attributes
            var days = button.data('days');
            var type = button.data('type');
            var begin = button.data('begin');
            var end = button.data('end');
            var description = button.data('description');
            var terms = button.data('terms');
            var max_qty = button.data('qty');
            var max_daily = button.data('daily');
            var price = button.data('price');

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            modal.find('.modal-title span').text(title);
            modal.find(".modal-body input[name='id']").val(dealID);
            modal.find(".modal-body select[name='store_id']").val(store);
            modal.find(".modal-body input[name='title']").val(dealTitle);
            modal.find(".modal-body select[name='type']").val(type);
            modal.find(".modal-body input[name='days']").val(days);
            modal.find(".modal-body input[name='begin']").val(begin);
            modal.find(".modal-body input[name='end']").val(end);
            modal.find(".modal-body input[name='max_quantity']").val(max_qty);
            modal.find(".modal-body input[name='max_daily_limit']").val(max_daily);
            modal.find(".modal-body input[name='price']").val(price);
            if (description) {
                modal.find(".modal-body textarea[name='description']").val(description);
            }
            if (terms) {
                modal.find(".modal-body textarea[name='terms']").val(terms);
            }
        });
    </script>
@append