<div class="form-group">
    <label>Country</label>
    <select class="form-control countries" name="country_id" type="text" required onchange="changeCountry(this)">
        @foreach(App\Country::all() as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
    </select>
    @section('scripts')
        <script>
            var changeCountryRoute = "{{ route('api_get_country') }}";
        </script>
    @append
</div>