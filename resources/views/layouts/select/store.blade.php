<div class="form-group">
    <label>Select Store</label>
    <select class="form-control stores" name="store_id" required onchange="changeStore(this)">
        @foreach(App\Store::orderBy('name')->get() as $store)
            <option value="{{ $store->id }}" title="{{ $store->city->name }}">
                {{ "{$store->name}, {$store->city->getOriginal('name')}" }}
            </option>
        @endforeach
    </select>
    @section('scripts')
        <script>
            var changeStoreRoute = "{{ route('api_get_store') }}";
        </script>
    @append
</div>