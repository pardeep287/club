<table class="table table-hover" id="states-table">
    <thead>
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Action</td>
        </tr>
    </thead>

    <tbody>
        @foreach($states as $state)
        <tr>
            <td>{{ $state->id }}</td>
            <td>{{ $state->name }}</td>
            <td>
                <a class="btn btn-sm btn-warning" href="{{ route('city_selective',[$state->country->id, $state->id]) }}">
                    <span class="fa fa-tag"></span> View Cities ({{ $state->cities->count() }})
                </a>
                @if(authority_match(\App\User::$admin))
                <a class="btn btn-sm btn-danger"  href="{{ route('state_delete',[$state->country->id, $state->id]) }}" onclick="event.preventDefault(); document.getElementById('state-{{ $state->id }}').submit();">
                    <span class="fa fa-trash"></span> Delete
                </a>
                <form id="state-{{ $state->id }}" action="{{ route('state_delete', [$state->country->id, $state->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}{!! method_field('delete') !!}
                </form>

                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#state-edit"
                    @foreach(array_keys($state->makeHidden(['booklets', 'subcities', 'created_at', 'updated_at', 'state'])->toArray()) as $key)
                    data-{{ $key }}="{{ array_get($state->getAttributes(), $key) }}"
                    @endforeach
                >
                    <span class="fa fa-edit"></span>  Edit state
                </button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@if(authority_match(\App\User::$admin) && $states->count() > 0) @include('admin.location.state.edit') @endif
@section('scripts')
    <script>
        var statesTable = $("#states-table");
        $(initialiseDataTable(statesTable));
    </script>
@append