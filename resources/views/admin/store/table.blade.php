<table class="table table-hover table-stripped" id="stores-table">
    <thead>
    <tr>
        <td>Avatar</td>
        <td>Store Name</td>
        <td>Mobile</td>
        <td>Action</td>
        <td>City</td>
        <td>Top Pick</td>
        <td>Categories</td>
        <td>Created</td>
        <td>Last Updated</td>
    </tr>
    </thead>
</table>

@if(authority_match(\App\User::$admin)) @include('admin.store.edit') @endif

@push('datatables')
    <script>
        var route_store_deals = "{!! route('query_store') !!}";
        var route_store_reports = "{!! route('store.reports') !!}";

        function getStoreAvatar(row) {
            return "<img class=\"img img-thumbnail\" width=\"96\" src=\" " + row.completeAvatar + "\">"
        }

        function getStoreDetailsButton(row) {
            return "<a class=\"btn btn-warning\" href=\" " + route_store_deals + "?id=" + row.id + "\"> " + "<span class=\"fa fa-tags\"></span>  " + 'Store Deals' + "</a>";
        }

        @if(authority_match(\App\User::$admin))
        function getStoreEditButton(row) {

            var categorySelection = row.categories.map(function (item) {
                return item.id
            });

            return "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#store-edit\"" + " data-id=\"" + row.id + "\"" + " data-name=\"" + row.name + "\"" + " data-mobile=\"" + row.mobile + "\"" + " data-address_1=\"" + row.address_1 + "\"" + " data-address_2=\"" + row.address_2 + "\"" + " data-address_3=\"" + row.address_3 + "\"" + " data-address=\"" + row.address + "\"" + " data-terms=\"" + row.terms + "\"" + " data-active=\"" + row.active + "\"" + " data-top_pick=\"" + row.top_pick + "\"" + " data-trusted=\"" + row.trusted + "\"" + " data-preferred=\"" + row.preferred + "\"" + " data-membership=\"" + row.membership + "\"" + " data-city_id=\"" + row.city.id + "\"" + " data-pincode=\"" + row.pincode + "\"" + " data-latitude=\"" + row.latitude + "\"" + " data-longitude=\"" + row.longitude + "\"" + " data-storecategories=\"[" + categorySelection + "]\"" + ">" + "<span class=\"fa fa-edit\"></span>  Edit Store </button>";
        }

        function getReporting(row) {
            return "<a class=\"btn btn-info\" href=\"" + route_store_reports + "?id=" + row.id + "\">" + "<span class=\"fa fa-book\"></span> " + "Reports" + "</a>";
        }

        @else
        function getStoreEditButton(row) {
            return "";
        }

        function getReporting(row) {
            return "";
        }

        @endif

        function getStoreCategoriesList(row) {
            var catList = "<ul class=\"list-group\">";

            $(row.categories).each(function (index, item) {
                catList += getCategoryList(item);
            });

            catList += "</ul>";

            return catList;

        }

        function getCategoryList(item) {
            return "<li class=\"list-group-item\">" + item.name + "</li>";
        }

        $(function () {
            $('#stores-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.storeData') !!}',
                columns: [
                    {
                        data: 'avatar', name: 'avatar', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getStoreAvatar(row);
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {
                        data: 'city.name', name: 'city.name', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getStoreDetailsButton(row) + " " + getStoreEditButton(row) + " " + getReporting(row);
                        }
                    },
                    {data: 'city.name', name: 'city.name', searchable: false, orderable: false,},
                    {
                        data: 'top_pick', name: 'top_pick',
                        render: function (data, type, row) {
                            var top = (data) ? "Top-Pick Store" : "-";
                            var trusted = (row.trusted) ? "Trusted Store" : "-";
                            var preferred = (row.preferred) ? "Preferred Store" : "-";

                            return row.membership.capitalize() + " Member" + "<br>" + top + "<br>" + trusted + "<br>" + preferred;
                        }
                    },
                    {
                        data: 'categories', name: 'categories', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            return getStoreCategoriesList(row);
                        }
                    },
                    {
                        data: 'created_at', name: 'created_at',
                        render: function (data) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'updated_at', name: 'updated_at',
                        render: function (data) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    }
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