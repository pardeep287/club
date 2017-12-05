<div class="form-group">
    <label>Category</label>
    <select class="form-control categories" @if(isset($type) && 'multiple' == strtolower($type)) name="categories[]"
            @else name="category_id" @endif required onchange="changeCategory(this)" {{ $type }}>
        @foreach(App\Category::orderBy('name')->get() as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @section('scripts')
        <script>
            var changeCategoryRoute = "{{ route('api_get_subcategories') }}";
        </script>
    @append
</div>