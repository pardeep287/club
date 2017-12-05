<table class="table table-hover" id="bonusdeal-table">
    <thead>
    <tr>
        <td>Id</td>
        <td>Title</td>
        <td>Type</td>
        <td>Status</td>
        <td>Action</td>
    </tr>
    </thead>

    <tbody>
    @foreach($bonusDeal as $bonusD)
        <tr>
            <td>{{ $bonusD->id }}</td>
            <td>{{ $bonusD->title }}</td>

            <td>{{ $bonusD->type }}</td>
            <td>@if($bonusD->status=='1'){{'Active' }}@else{{'Inactive'}}@endif</td>

            <td>

                @if(authority_match(\App\User::$admin))
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#bonusdeal-edit"
                            @foreach(array_keys($bonusD->makeHidden(['created_at','updated_at'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($bonusD->getAttributes(), $key) }}"
                            @endforeach data-action="{{ route('bonusdeal.update',[$bonusD->id]) }}">
                        <span class="fa fa-edit"></span> Edit Bonus Deal
                    </button>

                    <a class="btn btn-sm btn-info" href="{{ route('bonusdealcode.index')}}/{{$bonusD->id}}">
                        <i class="fa fa-ticket"></i> Coupons ({{ $bonusD->bonus_deal_codes_count }})
                    </a>

                    <a class="btn btn-sm btn-danger" href="{{ route('bonusdeal.destroy', [$bonusD->id]) }}"
                       onclick="event.preventDefault(); document.getElementById('bonusdeal-{{ $bonusD->id }}').submit();">
                        <span class="fa fa-trash"></span> Delete
                    </a>
                    <form id="bonusdeal-{{ $bonusD->id }}" action="{{ route('bonusdeal.destroy', [$bonusD->id]) }}"
                          method="post" style="display: none;">
                        {{ csrf_field() }}{!! method_field('delete') !!}
                    </form>

                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@if(authority_match(\App\User::$admin)) @include('admin.bonusdeal.edit') @endif


@section('scripts')
    <script>
        var bonusdealTable = $("#bonusdeal-table");
        $(initialiseDataTable(bonusdealTable));
    </script>
@append