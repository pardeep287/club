@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Reporting for
                <strong>
                    {{ $deal->title }}
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-stripped" id="dealsReport-table">
                    <thead>
                    <tr>
                        <td>Order ID</td>
                        <td>Client</td>
                        <td>Mobile</td>
                        <td>Status</td>
                        <td>Code</td>
                        <td>Created At</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('datatables')
    <script>
        $(function () {
            $('#dealsReport-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.dealReportData', $deal) !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'client_name', name: 'client_name', searchable: false, orderable: false},
                    {data: 'client_mobile', name: 'client_mobile', searchable: false, orderable: false},
                    {data: 'status', name: 'status'},
                    {data: 'deal_code', name: 'deal_code', searchable: false, orderable: false},
                    {data: 'created_at', name: 'created_at'},
                ],
                dom: 'Brtip',
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
