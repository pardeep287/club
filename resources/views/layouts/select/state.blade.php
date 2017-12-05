<div class="form-group">
    <label>State</label>
    <select class="form-control states" name="state_id" type="text" onchange="changeState(this)" required>
        @foreach(App\State::all() as $state)
            <option value="{{ $state->id }}">{{ $state->name }}</option>
        @endforeach
    </select>
    @section('scripts')
        <script>
            var changeStateRoute = "{{ route('api_get_state') }}";
        </script>
    @append
</div>