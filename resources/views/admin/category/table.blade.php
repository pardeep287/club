<table class="table table-stripped" id="categories-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>
                @if(authority_match(\App\User::$admin))
                    <button class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#categoryEditModal"
                            @foreach(array_keys($category->makeHidden(['created_at', 'updated_at'])->toArray()) as $key)
                            data-{{ $key }}="{{ array_get($category->getAttributes(), $key) }}"
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
    @include('admin.category.edit')
@endif


@section('scripts')
    <script>
        var categoriesTable = $("#categories-table");
        $(initialiseDataTable(categoriesTable));
    </script>
@append