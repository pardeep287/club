<form method="post" action="{{ route($form['route']) }}" class="form-inline">
    {{ csrf_field() }} {!! method_field($form['method']) !!}
    <input type="hidden" name="id">
    @include('layouts.select.category',['type' => ''])
    <div class="form-group">
        <label for="name" class="form-controllabel">Sub Category Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="a unique name">
    </div>
    <div class="form-group">
        <label for="description" class="form-controllabel">Sub Category Description</label>
        <textarea class="form-control" name="description" rows="1" cols="36" placeholder="something that guests can associate with">{{ old('description') }}</textarea>
    </div>

    @if(!($form['handlesubmit']) )
    <div class="form-group">
        <button class="btn btn-primary">
            <span class="fa fa-plus"></span> Create Category
        </button>
    </div>
    @endif
</form>