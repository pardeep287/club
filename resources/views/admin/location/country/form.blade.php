<form class="row" method="post" action="{{ route($route_name) }}" enctype="multipart/form-data">
    {{ csrf_field() }} {!! method_field($route_method) !!}
    <input type="hidden" name="id">

    <div class="col-md-12">

        <div class="col-md-2">
            <div class="form-group">
                <label for="name" class="form-control-label">Name</label>
                <input type="text" class="form-control" name="name" required placeholder="India">
                <input type="text" class="form-control" name="short_name" required placeholder="IND">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="locale" class="form-control-label">Locale</label>
                <input type="text" class="form-control" name="locale" required placeholder="en">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="currency_name" class="form-control-label">Currency</label>
                <input type="text" class="form-control" name="currency_name" required placeholder="Indian Rupees">
                <input type="text" class="form-control" name="currency_code" required placeholder="INR">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="mobile_prefix" class="form-control-label">Mobile</label>
                <input type="text" class="form-control" name="mobile_prefix" required placeholder="+91">
            </div>
        </div>

        @if($route_method === 'post')

            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-controllabel">Create New Country</label>
                    <button class="btn btn-primary"><i class="fa fa-globe"></i> Add Country</button>
                </div>
            </div>

        @endif
    </div>
</form>
