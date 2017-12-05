<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Select Store</label>
            <select class="form-control" name="store_id" id="selected_store" onchange="select_store();">
                <option value="0">All</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @if ($store->id === $selected_store) selected @endif>
                        {{ $store->name }}
                    </option>
                @endforeach 
            </select> @section('scripts')

            <script>
                var home_route = "{{ route('dashboard') }}";
                var all_deals = "{{ route('deal') }}";


                function select_store() {
                    var store = $("#selected_store");
                    if (store.val() != 0) {
                        window.location.href = home_route + "/store/" + store.val() + "/deal";
                    } else {
                        window.location.href = all_deals;
                    }
                }
            </script>
            @append
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Enter Mobile</label>
            <input class="form-control" id="" type="text" placeholder="+91 8566845501">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <br>
            <button class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
        </div>
    </div>
</div>