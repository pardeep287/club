<table class="table table-hover" id="bonusdeal-table">
    <thead>
    <tr>
        <td>Id</td>
        <td>Bonus Deal</td>
        <td>Master Code</td>
        <td>Code</td>
        <td>Used Mobile</td>
        <td>User Name</td>
        <td>Status</td>
    </tr>
    </thead>

    <tbody>
    @if(false)
        @foreach($bonusDealCode as $bonusDealCd)
            <tr>
                <td>{{ $bonusDealCd->id }}</td>
                <td>{{ $bonusDealCd->bonusdeal->title }}</td>
                <td>{{ $bonusDealCd->master_code }}</td>
                <td>{{ $bonusDealCd->code }}</td>
                <td>{{ "{$bonusDealCd->usedBy->mobile}, {$bonusDealCd->usedBy->name}" }}</td>
                <td>@if($bonusDealCd->status=='1'){{'Active' }}@else{{'Inactive'}}@endif</td>
                <td>
                    @if(authority_match(\App\User::$admin))
                        <a class="btn btn-sm btn-danger" href="{{ route('bonusdealcode.destroy', [$bonusDealCd->id]) }}"
                           onclick="event.preventDefault(); document.getElementById('bonusdealcode-{{ $bonusDealCd->id }}').submit();">
                            <span class="fa fa-trash"></span> DeleteṢ
                        </a>
                        <form id="bonusdealcode-{{ $bonusDealCd->id }}"
                              action="{{ route('bonusdealcode.destroy', [$bonusDealCd->id]) }}" method="post"
                              style="display: none;">
                            {{ csrf_field() }}{!! method_field('delete') !!}
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach

    @section('scripts')
        <script>
            var bonusdealTable = $("#bonusdeal-table");
            $(initialiseDataTable(bonusdealTable));
        </script>
    @append
    @endif

    </tbody>
</table>

@push('datatables')
    <script>
        var bonusDealCouponRoute = '{!! route("datatables.bonusDeal.lakshay", $id) !!}';

        $(function () {
            $('#bonusdeal-table').DataTable(
                {
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    ajax: bonusDealCouponRoute,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'bonus_deal.title', name: 'bonus_deal.title', searchable: false, orderable: false},
                        {data: 'master_code', name: 'master_code'},
                        {data: 'code', name: 'code'},
                        {data: 'used_by.mobile', name: 'used_by.mobile'},
                        {data: 'used_by.name', name: 'used_by.name'},
                        {
                            data: 'status', name: 'status',
                            render: function (data) {
                                return (data == 0) ? "Used" : "Created";
                            }
                        },
                    ],
                    dom: 'Bfrtip',
                    extend: 'collection',
                    lengthMenu: [
                        [10, 25, -1],
                        ['10 rows', '25 rows', "Show All"]
                    ],
                    buttons: [
                        'pageLength',
                        'columnsToggle'
                    ],
                }
            );
        });
    </script>

@endpush