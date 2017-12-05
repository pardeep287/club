<table class="table table-stripped" id="countries-table">
    <thead>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Locale</td>
        <td>Currency</td>
        <td>Mobile Prefix</td>
        <td>Action</td>
    </tr>
    </thead>

    <tbody>
    @foreach($countries as $country)
        <tr>
            <td>{{ $country->id }}</td>
            <td>{{ "$country->name ($country->short_name)" }}</td>
            <td>{{ "$country->locale" }}</td>
            <td>{{ "$country->currency_name ($country->currency_code)" }}</td>
            <td>{{ "$country->mobile_prefix" }}</td>
            <td>
                <a href="{{ route('state_selective', $country->id) }}" class="btn btn-sm btn-primary">
                    States ({{ $country->states->count() }})
                </a>
                @if(authority_match(\App\User::$admin))
                    <button
                            data-target="#country-edit"
                            data-toggle="modal"
                            @foreach(array_keys($country->makeHidden(['states', 'created_at', 'updated_at'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($country->getAttributes(), $key) }}"
                            @endforeach
                            class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit Country
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    <script>
        var countriesTable = $("#countries-table");
        $(initialiseDataTable(countriesTable));
    </script>
@append