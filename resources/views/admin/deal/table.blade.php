<table class="table table-hover" id="deal-list-table">
    <thead>
    <tr>
        <td>Id</td>
        <td>Avatar</td>
        <td>Store Name</td>
        <td>City</td>
        <td>Deal Kind</td>
        <td>Deal Title</td>
        <td>Deal Reach</td>
        <td>Price</td>
        <td>Type</td>
        <td>Price Type</td>
        <td>Discount</td>
        <td>Begin</td>
        <td>End</td>
        <td>Created At</td>
        <td>Updated At</td>
        <td>Active</td>
        @if(authority_match(\App\User::$admin))
            <td>Action</td>
        @endif
    </tr>
    </thead>
</table>

@push('datatables')
    <script>

        var dealViewRoute = "{{ route("deal.view") }}";

        function getDealAvatar(deal) {
            return "<a href=\"" + dealViewRoute + "?deal=" + deal.id + "\" target='_blank' >" + "<img class=\"img img-thumbnail\" width=\"96\" src=\" " + deal.completeAvatar + "\">" + "</a>";
        }

                @if(authority_match(\App\User::$admin))
        var minCouponCount = parseInt("{{ App\DefaultValue::getValue('mincouponcount', 1000)['clean'] }}");
        var dealCouponRoute = "{{ route('deal_coupons') }}";

        function getDealCouponsPage(deal) {
            var btnClass = 'btn-primary';
            var couponsCount = deal.couponsLeft;
            if (couponsCount <= minCouponCount) {
                btnClass = 'btn-danger';
            }
            var btn = "<a class=\"btn btn-sm " + btnClass + "\" href=\"" + dealCouponRoute + "?id=" + deal.id + "\"><i class=\"fa fa-ticket\"></i> Coupons ( " + couponsCount + " )</a>";
            return btn;
        }

        var dealEditRoute = "{{ route('deal_edit_page') }}";

        function getDealEditButton(deal) {
            var btn = "<a class=\"btn btn-sm btn-warning\" href=\"" + dealEditRoute + "?id=" + deal.id + "\"><i class=\"fa fa-pencil\"></i> Edit </a>";
            return btn;
        }

        var dealReportRoute = "{{ route('deal.reports') }}";

        function getDealReports(deal) {
            var btn = "<a class=\"btn btn-sm btn-info\" href=\"" + dealReportRoute + "?id=" + deal.id + "\"><i class=\"fa fa-book\"></i> Reports </a>";
            return btn;
        }

                @endif

        var dealDataRoute = '{!! route($table_data_route) !!}';
        @if(isset($store))
            dealDataRoute += "?store_id={{$store->id}}";
        @endif

        $(function () {
            $('#deal-list-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: dealDataRoute,
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'avatar', name: 'avatar', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getDealAvatar(row);
                        }
                    },
                    {data: 'store.name', name: 'store.name'},
                    {data: 'city', name: 'city', searchable: false, orderable: false},
                    {
                        data: 'kind', name: 'kind',
                        render: function (data) {
                            return data.capitalize();
                        }
                    },
                    {data: 'title', name: 'title',},
                    {
                        data: 'reach', name: 'reach',
                        render: function (data) {
                            return data.capitalize();
                        }
                    },
                    {
                        data: 'price', name: 'price',
                        render: function (data) {
                            return "₹ " + data + "/-";
                        }
                    },
                    {
                        data: 'type', name: 'type',
                        render: function (data) {
                            return data.capitalize();
                        }
                    },
                    {
                        data: 'price_type', name: 'price_type', searchable: false, orderable: false,
                        render: function (data) {
                            return (data.replace("_", " ")).capitalize();
                        }
                    },
                    {data: 'discountMessage', name: 'discountMessage', searchable: false, orderable: false},
                    {data: 'begin', name: 'begin'},
                    {data: 'end', name: 'end'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {
                        data: 'active', name: 'active', searchable: false, orderable: false,
                        render: function (data) {
                            if (data) {
                                return "Active";
                            } else {
                                return "Inactive";
                            }
                        }
                    },

                        @if(authority_match(\App\User::$admin))
                    {
                        data: 'action', name: 'action', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            var actions = "";

                            actions += " " + getDealReports(row);

                            actions += " " + getDealCouponsPage(row);

                            actions += " " + getDealEditButton(row);

                            return actions;
                        }
                    },
                    @endif

                ],
                dom: 'Bfrtip',
                extend: 'collection',
                lengthMenu: [
                    [10, 25],
                    ['10 rows', '25 rows']
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