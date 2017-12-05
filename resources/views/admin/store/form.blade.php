<form class="col-md-12" method="post" action="{{ route($form['route']) }}" enctype="multipart/form-data">
    {{ csrf_field() }} {!! method_field($form['method']) !!}
    <div class="row">
        <div class="col-md-3">@include('layouts.select.country',['selected_country' => 0])</div>
        <div class="col-md-3">@include('layouts.select.state', ['selected_state' => 0])</div>
        <div class="col-md-3">@include('layouts.select.city', ['selected_city' => 0])</div>
        <div class="col-md-3">@include('layouts.select.subcity', ['selected_sub_city' => 0])</div>
        <class class="col-md-12">@include('layouts.select.category',['type' => 'multiple'])</class>
        @section('scripts')
            <script src="{{ asset('/js/lakshay.js') }}"></script>
        @append
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Store Name</label>
                <input class="form-control" name="name" type="text" required value="{{ old('name') }}">
            </div>
        </div>

        <div class="col-md-6">
            <label>Store Image</label>
            <input class="form-control" name="avatar" type="file" accept="image/*">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label>
                <small>Address</small>
            </label>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Line 1</label>
                    <input class="form-control" name="address_1" type="text" required value="{{ old('address_1') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Line 2</label>
                    <input class="form-control" name="address_2" type="text" value="{{ old('address_2') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Line 3</label>
                    <input class="form-control" name="address_3" type="text"
                           value="{{ (null !== old('address_3')) ? old('address_3') : "Jalandhar"}}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input class="form-control" name="pincode" type="text" value="144001"
                       value="{{ (null !== old('pincode')) ? old('pincode') : App\DefaultValue::getValue('jbPinCode_1', '144001')['clean'] }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input class="form-control" name="mobile" type="text"
                       value="{{ (null !== old('mobile')) ? old('mobile') : App\DefaultValue::getValue('jbcare')['clean'] }}">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="terms">Store Terms</label>
            <textarea name="terms" class="form-control"
                      rows="10">{{ (null !== old('terms')) ? old('terms') : App\DefaultValue::getValue('storeTerms', "Club JB Store Terms")['value'] }}</textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-12">
            <label for="google">
                <small>Special Parameters</small>
            </label>
        </div>

        <div class="col-md-4">
            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        <input name="active" type="checkbox" checked> Active
                    </label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        <input name="top_pick" type="checkbox"> Top Pick
                    </label>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="checkbox">
                <label>
                    <input name="trusted" type="checkbox"> Trusted Store
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="checkbox">
                <label>
                    <input name="preferred" type="checkbox"> Preferred Store
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <label for="membership">Memebership</label>
            <select name="membership" id="membership" class="form-control">
                @foreach((new \App\Store())->membershipOptions() as $membershipOption)
                    <option value="{{ strtolower($membershipOption) }}"> {{ ucwords(str_replace('_', ' ', $membershipOption)) }} </option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" class="form-control"
                       value="{{ (null !== old('latitude')) ? old('latitude') : '31.3245' }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="latitude">Longitude</label>
                <input type="text" name="longitude" class="form-control"
                       value="{{ (null !== old('longitude')) ? old('longitude') : '75.5812' }}">
                <input type="hidden" name="id" class="form-control">
            </div>
        </div>
    </div>

    @if(!($form['handlesubmit']) )
        <div class="col-md-12">
            <div class="col-md-2 col-md-offset-10">
                <div class="form-group">
                    <br/>
                    <button class="btn btn-primary"><i class="fa fa-plus"></i> Submit</button>
                </div>
            </div>
        </div>
    @endif
</form>