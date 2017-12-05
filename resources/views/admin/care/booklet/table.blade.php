<table class="table table-stripped" id="booklet-purchase-table">
    <thead>
        <tr>
            <td>Transaction ID</td>
            <td>Client</td>
            <td>Mobile</td>
            <td>Booklet</td>
            <td>Code</td>
            <td>User</td>
            <td>Remarks</td>
            <td>Price</td>
            <td>Date</td>
        </tr>
    </thead>
</table>

@push('datatables')
    <script>
        $(function() {
            $('#booklet-purchase-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.bookletPurchaseData') !!}',
                columns: [
                    { data: 'id', name: 'id',
                        render: function(data, type, row){
                            return data.lpad('0', 8);
                        }
                    },
                    { data: 'client.name', name: 'client.name' },
                    {data: 'client.mobile', name: 'client.mobile'},
                    { data: 'booklet.name', name: 'booklet.name', searchable: false, orderable: false },
                    { data: 'code', name: 'code' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'remarks', name: 'remarks' },
                    { data: 'price', name: 'price' },
                    { data: 'created_at', name: 'created_at' },
                ],
                colReorder: true,
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