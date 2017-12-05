<div class="form-group">
    <label>Sales Team</label>
    <select class="form-control sales clients" @if(isset($type) && 'multiple' == strtolower($type)) name="sales[]"
            @else name="sales_id" @endif required {{ $type }}>
        @foreach(App\Client::where('client_type','sales')->orderBy('name')->get() as $executive)
            <option value="{{ $executive->id }}">
                {{ $executive->name }}, {{ $executive->mobile }}, {{ $executive->city->name }}
            </option>
        @endforeach
    </select>
</div>