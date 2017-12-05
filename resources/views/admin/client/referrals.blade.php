@extends('layouts.app')

@section('content')

    <div class="page-header">

    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{ $client->mobile }}</h1>
            <h2>{{ $client->name }}</h2>
            <h6>{{ ucwords($client->client_type) }}</h6>
            <h3>Direct Referrals: {{ $client->referredTo()->count() }}</h3>
            <h3>InDirect Referrals: {{ $client->indirectReferral }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-stripped" id="referrals-table">
                <thead>
                <tr>
                    <th>Mobile</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Created At</th>
                    <th>Device ID</th>
                    <th>Referrals</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('datatables')

    <script>
        var route_referrals_data = "{!! route('datatables.client.referralData', $client) !!}";
        var route_client_referrals = "{!! route('client_referrals') !!}";


        function getClientReferralsButton(row)
        {
            return "<a class=\"btn btn-info\" href=\" " + route_client_referrals + "?mobile=" + row.mobile + "\"> " + "<span class=\"fa fa-users\"></span>  " + 'Referrals' + "(" + row.total_referrals +")" + "</a>";
        }

        $(function () {
            $('#referrals-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: route_referrals_data,
                columns: [
                    {data: 'mobile', name: 'mobile'},
                    {data: 'name', name: 'name'},
                    {data: 'client_type', name: 'client_type',
                        render: function(data){
                            return data.capitalize();
                        }
                    },
                    {
                        data: 'email', name: 'email', searchable: false, orderable: false,
                        render: function (data) {
                            if (data) {
                                return data;
                            }
                        else {
                                return "--";
                            }
                        }
                    },
                    {data: 'city.name', name: 'city.name', searchable: false, orderable: false},
                    {
                        data: 'id', name: 'id',
                        render: function (data, type, row) {
                            if (row.created_at) {
                                return row.created_at;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'device_id', name: 'device_id',
                        render: function (data) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },

                    {data: 'total_referrals', name: 'total_referreals', searchable: false, orderable: false,
                        render: function(data, type, row)
                        {
                            return getClientReferralsButton(row);
                        }
                    },
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
    </script>

@endpush