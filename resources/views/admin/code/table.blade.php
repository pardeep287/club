<table class="table table-stripped" id="booklet-codes-table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Code</td>
            <td>Status</td>
            <td>Status Message</td>
            <td>Begin</td>
            <td>End</td>
        </tr>
    </thead>
</table>

@push('datatables')
<script>
    $(function() {
        $('#booklet-codes-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.bookletCodeData', $booklet) !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'status', name: 'status',
                    render: function(data, type, row){
                        return data.capitalize();
                    }
                },
                { data: 'statusMessage', name: 'statusMessage', searchable: false, orderable: false },
                { data: 'begin', name: 'begin' },
                { data: 'end', name: 'end' },
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