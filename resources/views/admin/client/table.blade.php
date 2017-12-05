<table class="table table-stripped table-responsive" id="clients-table">
    <thead>
    <tr>
        <th>Avatar</th>
        <th>Client</th>
        <th>Type</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Device ID</th>
        <th>Referred By</th>
        <th>Total Referrals</th>
        <th>City At</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    </thead>
</table>

@if(authority_match(\App\User::$admin)) @include('admin.client.modal',['modalid' => 'client-edit' ,'formaction'=>'client_edit','formmethod'=> 'patch']) @endif

@push('datatables')
    <script>
        var route_client_history = "{!! route('client.history') !!}";
        var route_client_referrals = "{!! route('client_referrals') !!}";

        function getClientAvatar(row) {
            return "<img class=\"img img-thumbnail\" width=\"48\" src=\" " + "/uploads/avatars/clients/jbclient.png" + "\">"
        }

        function getClientDetailsButton(row) {
            return "<a class=\"btn btn-warning\" href=\" " + route_client_history + "?mobile=" + row.mobile + "\"> " + "<span class=\"fa fa-user\"></span>  " + 'View Client' + "</a>";
        }

        function getClientReferralsButton(row) {
            return "<a class=\"btn btn-info\" href=\" " + route_client_referrals + "?mobile=" + row.mobile + "\"> " + "<span class=\"fa fa-users\"></span>  " + 'Referrals' + "(" + row.total_referrals + ")" + "</a>";
        }

        function getClientEditButton(row) {
            @if(authority_match(\App\User::$admin))
                return "<button type=\"button\" class=\"btn btn-primary btn-sm \" data-toggle=\"modal\" data-target=\"#client-edit\" data-id=\"" + row.id + "\" data-city=\"" + row.city_id + "\" data-name=\"" + row.name + "\" data-email=\"" + row.email + "\" data-address=\"" + row.address + "\" data-mobile=\"" + row.mobile + "\" data-client_type=\"" + row.client_type + "\"> " + "<span class=\"fa fa-edit\"></span> Edit Client" + "</button>";
            @else
                return "";
            @endif
        }

        $(function () {
            $('#clients-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.clientData') !!}',
                columns: [
                    {
                        data: 'avatar', name: 'avatar', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getClientAvatar(row);
                        }
                    },
                    {data: 'name', name: 'name'},
                    {
                        data: 'client_type', name: 'client_type',
                        render: function (data) {
                            return data.capitalize();
                        }
                    },
                    {data: 'mobile', name: 'mobile'},
                    {data: 'email', name: 'email'},
                    {
                        data: 'device_id', name: 'device_id',
                        render: function (data) {
                            var dev = data;
                            if (data) {
                                dev = data;
                            } else {
                                dev = '-';
                            }
                            return dev;
                        }
                    },
                    {data: 'referred_by.mobile', name: 'referred_by.mobile', searchable: false, orderable: false},
                    {
                        data: 'total_referrals', name: 'total_referrals',
                        render: function (data, type, row) {
                            return getClientReferralsButton(row);
                        }
                    },
                    {data: 'city.name', name: 'city.name'},
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
                        data: 'id', name: 'action', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getClientDetailsButton(row) + " " + getClientEditButton(row);
                        }
                    },
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