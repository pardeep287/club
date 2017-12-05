<table class="table table-stripped" id="deal-coupons-table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Code</td>
            <td>Method</td>
            <td>Status</td>
            <td>Client Name</td>
            <td>Client Mobile</td>
            <td>Client Dated</td>
            <td>Begin</td>
            <td>End</td>
        </tr>
    </thead>
</table>

@push('datatables')
<script>

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };

    $(function() {
        $('#deal-coupons-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.dealCouponData', $deal) !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'method', name: 'method',
                    render: function(data, type, row){
                        return data.capitalize();
                    }
                },
                { data: 'status', name: 'status',
                    render: function(data, type, row){
                        return data.capitalize();
                    }
                },
                { data: 'client.name', name: 'client.name', searchable: false, orderable: false },
                { data: 'client.mobile', name: 'client.mobile', searchable: false, orderable: false },
                { data: 'client.dated', name: 'client.dated', searchable: false, orderable: false },
                {data: 'begin', name: 'begin'},
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

</script>

@endpush