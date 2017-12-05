<table class="table table-stripped" id="subCities-table">
    <thead>
    <tr>
        <td>ID</td>
        <td>Name</td>
        @if((strpos(route('subcity'), Request::path()) !== false))
            <td>State</td>
            <td>Country</td>
        @endif
        <td>Action</td>
    </tr>
    </thead>

    <tbody>
    @foreach($subCities as $subcity)
        <tr>
            <td>{{ $subcity->id }}</td>
            <td>{{ $subcity->name }}</td>
            @if((strpos(route('subcity'), Request::path()) !== false))
                <td>{{ $subcity->city->state->name }}</td>
                <td>{{ $subcity->city->state->country->name }}</td>
            @endif
            <td>
                @if(authority_match(\App\User::$admin))
                    <button data-target="#subcity-edit" data-toggle="modal"
                            @foreach(array_keys($subcity->makeHidden(['created_at', 'updated_at'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($subcity->getAttributes(), $key) }}"
                            @endforeach
                            class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit Sub City
                    </button>
                @else
                    Admins Only
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if(authority_match(\App\User::$admin)) @include('admin.location.subcity.edit') @endif


@section('scripts')
    <script>
        var subCitiesTable = $("#subCities-table");
        $(initialiseDataTable(subCitiesTable));
    </script>
@append