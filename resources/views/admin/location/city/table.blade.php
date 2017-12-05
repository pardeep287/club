<table class="table table-hover" id="cities-table">
    <thead>
    <tr>
        <td>Id</td>
        <td>Name</td>
        @if((strpos(route('city'), Request::path()) !== false))
            <td>Country</td>
        @endif
        <td>Action</td>
    </tr>
    </thead>

    <tbody>
    @foreach($cities as $city)
        <tr>
            <td>{{ $city->id }}</td>
            <td>{{ $city->name }}</td>
            @if((strpos(route('city'), Request::path()) !== false))
                <td>{{ $city->state->country->name }}</td>
            @endif
            <td>
                <a class="btn btn-sm btn-warning"
                   href="{{ route('city_booklets', [$city->state->country, $city->state, $city]) }}">
                    <span class="fa fa-tag"></span> View Booklets ({{ $city->booklets->count() }})
                </a>
                <a class="btn btn-sm btn-warning"
                   href="{{ route('subcity_selective', [$city->state->country, $city->state, $city]) }}">
                    <span class="fa fa-tag"></span> View Subcities ({{ $city->subCities->count() }})
                </a>
                @if(authority_match(\App\User::$admin))
                    <a class="btn btn-sm btn-danger"
                       href="{{ route('city_delete', [$city->state->country->id, $city->state->id, $city->id]) }}"
                       onclick="event.preventDefault(); document.getElementById('city-{{ $city->id }}').submit();">
                        <span class="fa fa-trash"></span> Delete
                    </a>
                    <form id="city-{{ $city->id }}"
                          action="{{ route('city_delete', [$city->state->country->id, $city->state->id, $city->id]) }}"
                          method="POST" style="display: none;">
                        {{ csrf_field() }}{!! method_field('delete') !!}
                    </form>

                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#city-edit"
                            @foreach(array_keys($city->makeHidden(['booklets', 'subcities', 'created_at', 'updated_at', 'state'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($city->getAttributes(), $key) }}"
                            @endforeach
                            data-state_id="{{ $city->state->id }}"
                    >
                        <span class="fa fa-edit"></span> Edit city
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if(authority_match(\App\User::$admin) && $cities->count() > 0) @include('admin.location.city.edit') @endif


@section('scripts')
    <script>
        var citiesTable = $("#cities-table");
        $(initialiseDataTable(citiesTable));
    </script>
@append