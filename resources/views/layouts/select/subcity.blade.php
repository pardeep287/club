<div class="form-group">
    <label>Sub City</label>
    <select class="form-control subcities" name="sub_city_id" type="text">
        @foreach(App\SubCity::all() as $subCity)
            <option value="{{ $subCity->id }}">{{ $subCity->name }}</option>
        @endforeach
    </select>
</div>