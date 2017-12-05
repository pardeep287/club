<div class="modal fade" id="deal-use">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-tag"></i> Deal </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mobile No</label>
                            <input id="mobile_fetch" type="text" name="mobile_no" class="form-control" required>
                            <button class="btn btn-warning" onclick="fetch_user()">
                                Find
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row details">
                    <form action="{{ route('deal_use') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">

                            <div class="col-md-6">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="3" required></textarea>
                            </div>

                        </div>
                        <input type="hidden" name="deal_id" value="{{ old('deal_id') }}" class="form-control" required>
                        <input type="hidden" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control" required>
                    </form>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('scripts')

<script>
    var mobile, deal, dds;
    var getUser = "{{ route('user_details') }}";
    var getTransactions = "{{ route('user_transactions_only') }}";

    function fetch_user() {
        mobile = $("#mobile_fetch").val();

        data = {
            mobile: mobile,
            deal: selectedDeal
        };

        // $.post(getTransactions, data, function (result) {
        //     dds = result;
        //     $("#clientTransactions tbody").html = result;
        // });

        $.post(getUser, data, function (result) {
            if (!$.isEmptyObject(result)) {
                var client = result['client'];
                if (client == null) {
                    $("#deal-use form input[name='name']").val("");
                    $("#deal-use form input[name='email']").val("");
                    $("#deal-use form textarea[name='address']").val("");
                } else {
                    $("#deal-use form input[name='name']").val(client.name);
                    $("#deal-use form input[name='email']").val(client.email);
                    $("#deal-use form textarea[name='address']").val(client.address);
                }

                if (result['allowed'] != true) {
                    $("#deal-use button.submit").hide();
                    alert('You have used this deal to maximum already');
                } else {
                    $("#deal-use button.submit").show();
                }

            } else {
                $("#deal-use form input[name='name']").val("");
                $("#deal-use form input[name='email']").val("");
                $("#deal-use form textarea[name='address']").val("");
            }
        }, "json");

        $("#deal-use form input[name='mobile_no']").val(mobile);

        $("#deal-use div.details").show();
    }
</script>

<script>
    var selectedDeal;
    $('#deal-use').on('show.bs.modal', function (event) {
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal

        var dealID = button.data('deal');
        selectedDeal = dealID;
        var dealTitle = button.data('title');
        var dealStore = button.data('store');
        var title = "Get " + dealTitle + " at " + dealStore; // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        modal.find('.modal-title').text(title);
        modal.find(".modal-body form input[name='deal_id']").val(dealID);


        $("#deal-use div.details").hide();
    });

    $("#deal-use button.submit").on('click', function (event) {
        $("#deal-use form").submit();
    });
</script>
@append