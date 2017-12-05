@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li class="active"><span class="fa fa-flag"></span> Transactions</li>
        </ol>
    </div>


    <div class="row">
        <h3 class="page-title">CC Avenue Transactions Reporting</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div id="status_filter"></div>
                    <div id="creation_date_filter"></div>
                    <div id="updation_date_filter"></div>
                </div>
                <div class="panel-body">
                    <table class="table table-stripped table-responsive" id="transactions-table">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Client</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Amount</th>
                                <th>Tracking</th>
                                <th>Status</th>
                                <th>Order Type</th>
                                <th>Code</th>
                                <th>Remarks</th>
                                <th>Additional</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        </div>
    </div>

@endsection

@push('datatables')
<script>
$(function() {
    $('#transactions-table').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.ccData') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'client.name', name: 'client.name' },
            { data: 'client.mobile', name: 'client.mobile' },
            { data: 'client.email', name: 'client.email' },
            { data: 'client.city.name', name: 'client.city.name' },
            { data: 'amount', name: 'amount' },
            { data: 'tracking_id', name: 'tracking_id' },
            { data: 'status', name: 'status' },
            { data: 'order_type', name: 'order_type' },
            { data: 'report.code', name: 'report.code', searchable: false, orderable: false, render: function(data, type, row){
                return `<span class="text-` + row.report.type +`">` + data + `</span>`;
            } },
            { data: 'report.remarks', name: 'report.remarks', searchable: false, orderable: false },
            { data: 'report.additional', name: 'report.additional', searchable: false, orderable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ],
        colReorder: true,
        responsive: true,
        dom: 'Bfrtip',
        extend: 'collection',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: [
            'pageLength',
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'columnsToggle'
        ],
    });
});
</script>
@endpush