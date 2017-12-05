<table class="table table-stripped" id="subCategories-table">
    <thead>
    <tr>
        <th>Category</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    @foreach($subcategories as $subcategory)
        <tr>
            <td>{{ $subcategory->category->name }}</td>
            <td>{{ $subcategory->name }}</td>
            <td>{{ $subcategory->description }}</td>
            <td>
                @if(authority_match(\App\User::$admin))
                    <button class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#subcategoryEditModal"
                            @foreach(array_keys($subcategory->makeHidden(['category', 'created_at', 'updated_at'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($subcategory->getAttributes(), $key) }}"
                            @endforeach
                    >
                        <span class="fa fa-edit"></span> Edit
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if(authority_match(\App\User::$admin))
    @include('admin.subcategory.edit')
@endif


@section('scripts')
    <script>
        var subCategoriesTable = $("#subCategories-table");
        $(initialiseDataTable(subCategoriesTable));
    </script>
@append