<div class="form-group">
    <label>Sub Categories</label>
    <select class="form-control subcategories"
            @if(isset($type) && 'multiple' == strtolower($type)) name="subcategories[]" @else name="sub_category_id"
            @endif required {{ $type }}>
        @foreach(App\SubCategory::all() as $subcategory)
            <option value="{{ $subcategory->id }}" selected>{{ $subcategory->name }}</option>
        @endforeach
    </select>
</div>