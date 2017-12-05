@extends('layouts.app')
@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li class="active"><span class="fa fa-flag"></span> Reports</li>
        </ol>
    </div>

    <div class="row">
        <h3 class="page-title">Code Reporting</h3>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form>
                        <div class="form-group col-lg-6">
                            <label for="mobile" class="form-controllabel">Mobile Number</label>
                            <input type="phone" class="form-control" name="mobile" placeholder="Executive Mobile Number"
                                   value="{{ request()->mobile }}"
                                   pattern="^[789][0-9]{9}">
                        </div>
                        <div class="col-lg-3">
                            <label for="submit" class="form-controllabel">Fetch Transactions</label>
                            <br>
                            <button type="submit" class="btn btn-primary">
                                GO
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-header">
                    <h2>Filter</h2>

                    <div id="purchase_date_filter" class="col-md-3">
                        <label for="purchase_date">Purchase Date</label>
                    </div>

                    <div id="status_filter" class="col-md-3">
                        <label for="status">Code Status</label>
                    </div>

                    <div id="active_date_filter" class="col-md-3">
                        <label for="status">Activation Date</label>
                    </div>

                    <div class="panel-body">
                    </div>
                    <table class="table table-stipped" id="booklet-purchase-table">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Code</td>
                            <td>Sold By</td>
                            <td>Purchase Date</td>
                            <td>Executive</td>
                            <td>Mobile</td>
                            <td>Status</td>
                            <td>Activated By</td>
                            <td>Activation Mobile</td>
                            <td>Activation Date</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('datatables')

    <script>

        var bookletPurchasesRoute = "{!! route('datatables.client.bookletpurchases', $client) !!}";

        $(function () {
            $('#booklet-purchase-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: bookletPurchasesRoute,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'code', name: 'code'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'client.name', name: 'client.name'},
                    {data: 'client.mobile', name: 'client.mobile'},
                    {
                        data: 'status', name: 'status', searchable: false, orderable: false,
                        render: function (data) {
                            return data.capitalize();
                        }
                    },
                    {data: 'usedBy.name', name: 'usedBy.name', searchable: false, orderable: false},
                    {data: 'usedBy.mobile', name: 'usedBy.mobile', searchable: false, orderable: false},
                    {data: 'usedOn', name: 'usedOn', searchable: false, orderable: false},
                ],
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

        var yadcf_conf = [
            {
                column_number: 3,
                filter_type: 'range_date',
                date_format: 'dd-mm-yyyy',
                column_data_type: 'html',
                filter_container_id: 'purchase_date_filter',
                style_class: 'form-control'
            },
            {
                column_number: 5,
                filter_type: 'multi_select',
                select_type: 'chosen',
                filter_container_id: 'status_filter',
                style_class: 'form-control'
            },
            {
                column_number: 7,
                filter_type: 'range_date',
                date_format: 'dd-mm-yyyy',
                column_data_type: 'html',
                filter_container_id: 'active_date_filter',
                style_class: 'form-control'
            }
        ];

    </script>

@endpush