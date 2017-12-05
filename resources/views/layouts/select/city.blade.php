<div class="form-group">
    <label>City</label>
    <select class="form-control cities" name="city_id" type="text" required onchange="changeCity(this)">
        @foreach(App\City::all() as $city)
            <option value="{{ $city->id }}">
                {{ $city->name }}
            </option>
        @endforeach
    </select>
    @section('scripts')
        <script>
            var changeCityRoute = "{{ route('api_get_city') }}";
        </script>
    @append
</div>