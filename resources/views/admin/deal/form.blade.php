@extends('layouts.app')

@section('scripts')
    <script>
        var changeCountryRoute = "{{ route('api_get_country') }}";
        var changeStateRoute = "{{ route('api_get_state') }}";
        var changeCityRoute = "{{ route('api_get_city') }}";
    </script>
    <script src="{{ asset('/js/lakshay.js') }}"></script>
@append

@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li class="active"><span class="fa fa-tag"></span> Create Coupons</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Coupons</h1>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-primary create-coupons2">
            <div class="panel-heading dark-overlay">
                <h3><i class="fa fa-globe"></i> Deal Creation</h3>
            </div>
            <form role="form" action="{{ route($form_route) }}" method="POST" enctype="multipart/form-data">
                <div class="panel-body">

                    {{ csrf_field() }}
                    {{ method_field($form_type) }}
                    <input type='hidden' name='id' value="{{ $deal->id }}">
                    <div class="form-group">
                        <div class="highlight-bg">
                            <h3><i class="fa fa-globe"></i> Basic Details</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                @include('layouts.select.country')
                            </div>
                            <div class="col-md-3">
                                @include('layouts.select.state')
                            </div>
                            <div class="col-md-3">
                                @include('layouts.select.city')
                            </div>
                            <div class="col-md-3">
                                @include('layouts.select.subcity')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                @include('layouts.select.store')
                            </div>
                            <div class="col-md-4">
                                @include('layouts.select.category', ['type' => 'multiple'])
                            </div>
                            <div class="col-md-4">
                                @include('layouts.select.subcategory', ['type' => 'multiple'])
                                <small class="text-muted">Only select the subcategories that fall under store.</small>
                            </div>
                        </div>
                    </div>
                    <div class="highlight-bg">
                        <h3><i class="fa fa-ticket"></i> Coupon Details</h3>
                    </div>
                    <div class="row">
                        <div class="inner-form">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-3">Coupon Name</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input class="form-control" name="title" required type="text"
                                                   value="{{ (null !== (old('title'))) ? old('title') : $deal->title }}">
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6 no-padding">
                                        <label class="col-md-6">Handling Fees</label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input class="form-control" name="handling_fee" required type="number"
                                                       min="0"
                                                       value="{{ null !== (old('handling_fee')) ? old('handling_fee') : $deal->handling_fee }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 hidden">
                                        <label class="col-md-3">Coupon</label>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="payment_type" value="free">Free
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="payment_type" value="paid" checked>Paid
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-6 no-padding">
                                            <label class="col-md-6">Coupon Price</label>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select name="price_type" class="form-control">
                                                        <option value="coupon_price">Coupon Price</option>
                                                        <option value="deal_price">Deal Price</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding">
                                            <div class="form-group">
                                                <input class="form-control" name="price" required type="number" min="0"
                                                       value="{{ (null !== (old('price'))) ? old('price') : $deal->price }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 hidden">
                                        <label class="col-md-4">Deal Type</label>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="deal_type" checked>Coupon
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="deal_type">Complete Deal
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6 no-padding">
                                        <label class="col-md-6">Discount Type</label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="discount_type"
                                                           value="direct" {{ ($deal->discount_type === 'direct') ? 'checked' : '' }}>Rs
                                                    Off
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="discount_type"
                                                           value="percentage" {{ ($deal->discount_type === 'percentage') ? 'checked' : '' }}>%
                                                    Off
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" name="discount_value" required type="number"
                                                   min="0"
                                                   value="{{ (null !== (old('discount_value'))) ? old('discount_value') : $deal->discount_value }}">
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="avatar">Deal image</label>
                                    </div>
                                    <div class="imageupload">
                                        <div class="file-tab panel-body">
                                            <label class="btn btn-block btn-warning btn-file">
                                                <span>Upload Image</span>
                                                <!-- The file is stored here. -->
                                                <input type="file" name="avatar" accept="image/*">
                                            </label>
                                            <button type="button" class="btn btn-block btn-default">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Coupon Terms & Conditions</label>
                                    <textarea class="form-control" name="description"
                                              required>{{ (null !== (old('description'))) ? old('description') : $deal->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="highlight-bg">
                        <h3><i class="fa fa-flag"></i> Coupon & Company Terms & Conditions</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Store Terms & Conditions </label>
                                <textarea class="form-control" name="terms"
                                          required>{{ (null !== (old('terms'))) ? old('terms') : $deal->terms }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Terms & Conditions </label>
                                <textarea class="form-control" name="club_terms"
                                          required>{{ (null !== (old('club_terms'))) ? old('club_terms') : $deal->club_terms }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="highlight-bg">
                        <h3><i class="fa fa-calendar"></i> Coupon Validity</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Valid For Person</label>
                            <div class="form-group">
                                <input class="form-control" name="person_limit" required type="text"
                                       value="{{ (null !== (old('person_limit'))) ? old('person_limit') : $deal->person_limit }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>Start Date</label>
                            <div class="form-group">
                                <input name="begin" class="form-control" id="beginDate" required type="date"
                                       value="{{ (null !== (old('begin'))) ? old('begin') :  $deal->begin->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>End Date</label>
                            <div class="form-group">
                                <input name="end" class="form-control" id="endDate" required type="date"
                                       value="{{ (null !== (old('end'))) ? old('end') : $deal->end->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="hidden">
                            <div class="col-md-3">
                                <label>Valid for Days</label>
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="validity">All Days
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="validity" checked>Specific Days
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group specific-day-list">
                                    <label><input value="" type="checkbox"> Monday</label>
                                    <label><input value="" type="checkbox"> Tuesday</label>
                                    <label><input value="" type="checkbox"> Wednesday</label>
                                    <label> <input value="" type="checkbox"> Thursday</label>
                                    <label> <input value="" type="checkbox"> Friday</label>
                                    <label><input value="" type="checkbox"> Saturday</label>
                                    <label><input value="" type="checkbox"> Sunday</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reach">Deal Availability</label>
                                <select name="reach" class="form-control">
                                    <option value="city">City Specific</option>
                                    <option value="global">Global Deal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="highlight-bg">
                        <h3><i class="fa fa-money"></i> JB Coins</h3>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <label class="col-md-4">Max. JB Coins can Used </label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input class="form-control" name="coin_use" required type="text"
                                           value="{{ (null !== (old('coin_use'))) ? old('coin_us') : $deal->coin_use }}">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <label class="col-md-4">Max. JB Coins Get </label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input class="form-control" name="coin_get" required type="text"
                                           value="{{ (null !== (old('coin_get'))) ? old('coin_get') : $deal->coin_get }}">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="highlight-bg">
                        <h3><i class="fa fa-flag"></i> Validations and More</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group"><label>Max Quantity</label>
                                    <input type="number" class="form-control" name="max_quantity" required
                                           value="{{ (null !== (old('max_quantity'))) ? old('max_quantity') : $deal->max_quantity }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Max Daily Limit</label>
                                    <input type="number" min="1" class="form-control" name="max_daily_limit" required
                                           value="{{ (null !== (old('max_daily_limit'))) ? old('max_daily_limit') : $deal->max_daily_limit }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deal Kind</label>
                                <select name="kind" class="form-control" required>
                                    <option value="loose">Loose Deal</option>
                                    <option value="booklet">Booklet only Deal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Deal Type</label>
                                    <select name="type" class="form-control">
                                        <option value="normal">Normal Deal</option>
                                        <option value="explicit">Explicit Deal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Number Of Days</label>
                                    <input class="form-control" type="number" name="days" min="0"
                                           value="{{ (null !== (old('days'))) ? old('days') : $deal->days }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Deal Status</label>
                                <select name="active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="highlight-bg">
                        <h3><i class="fa fa-sellsy"></i> SEO Details</h3>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="col-md-2">Coupon Meta Title </label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control" name="meta_title" required type="text"
                                           value="{{ (null !== (old('meta_title'))) ? old('meta_title') : $deal->meta_title }}">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <label class="col-md-2">Coupon Meta Description </label>
                            <div class="col-md-10">
                                <div class="form-group">
                                <textarea class="form-control" rows="8" name="meta_description"
                                          required>{{ (null !== (old('meta_description'))) ? old('meta_description') : $deal->meta_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="highlight-bg">
                        <h3><i class="fa fa-flag"></i> Button Details </h3>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group"><label>Call to Avail</label>
                                    <input type="text" class="form-control store-contact" name="call_to" required
                                           value="{{ (null !== (old('call_to'))) ? old('call_to') : $deal->call_to }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message before Call</label>
                                    <textarea name="call_to_message" rows="10" class="form-control"
                                              required>{{ (null !== (old('call_to_message'))) ? old('call_to_message') : $deal->call_to_message }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <label for="master_pass" class="col-md-5">Master Password Required</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <select name="master_pass_required" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <label for="master_pass" class="col-md-5">Master Password</label>
                            <div class="col-md-7">
                                <input type="text" name="master_pass" class="form-control"
                                       value="{{ (null !== (old('master_pass'))) ? old('master_pass') : $deal->master_pass }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <label class="col-md-5">Redeem Offline</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <select name="redeem_offline" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <div class="row">

                        <div class="col-md-12">
                            <button type="reset" class="hidden btn btn-default pull-right cancel-btn">Cancel</button>
                            <button type="submit" class="btn btn-primary pull-right">Submit Coupon</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <link href="{{ asset('css/datetimepicker.css') }}" rel="stylesheet">
@append

@section('scripts')
    <script>

        @if ($form_type === 'patch')
            termsEditable = false;
        categoriesEditable = false;
        @else
            termsEditable = true;
        categoriesEditable = true;
                @endif

        var dealCK, storeCK, clubCK, metaDescCK, callToMessageCK;

        var text_club_terms = `{!! App\DefaultValue::getValue('jbTerms')['value'] !!}`;
        var text_store_terms = `{!! App\DefaultValue::getValue('storeTerms')['value'] !!}`;
        var master_pass_required = "{{ (null !== (old('master_pass_required'))) ? old('master_pass_required') : ($deal->master_pass_required) ? '1' : '0' }}";
        var booklet_kind = "{{ $deal->kind }}";

        var storeID = "{{ (null !== (old('store_id'))) ? old('store_id') : $store->id }}";
        var selected_country = "{{ (null !== (old('country_id'))) ? old('country_id') : $store->city->state->country->id }}";
        var selected_state = "{{ (null !== (old('state_id'))) ? old('state_id') : $store->city->state->id }}";
        var selected_city = "{{ (null !== (old('city_id'))) ? old('city_id') : $store->city->id }}";
        var selected_sub_city = "{{ (null !== (old('sub_city_id'))) ? old('sub_city_id') : (isset($store->sub_city->id)) ? $store->sub_city->id : '' }}";
        var selected_store = "{{ (null !== (old('store_id'))) ? old('store_id') : $store->id }}";

        var selected_reach = "{{ (null !== (old('reach'))) ? old('reach') : $deal->reach }}";


        var selected_price_type = "{{ (null !== old('price_type')) ? old('price_type') : $deal->price_type }}";
        var selected_redeem_offline = "{{ (null !== old('redeem_offline')) ? old('redeem_offline') : $deal->redeem_offline }}";

        var dealActive = "{{ $deal->getOriginal('active') }}";

                @if($form_type === 'patch')

        var selected_categories = [];
        @foreach($deal->categories as $category)
        selected_categories.push("{{ $category->id }}");
                @endforeach

        var selected_sub_categories = [];
        @foreach($deal->sub_categories as $subcategory)
        selected_sub_categories.push("{{ $subcategory->id }}");
        @endforeach
        @endif
        $(function () {
            dealCK = $("textarea[name='description']").ckeditor();
            storeCK = $("textarea[name='terms']").ckeditor();
            clubCK = $("textarea[name='club_terms']").ckeditor();
            callToMessageCK = $("textarea[name='call_to_message']").ckeditor();
            metaDescCK = $("textarea[name='meta_description']").ckeditor();

            $("select.countries").val(selected_country);
            $("select.states").val(selected_state);
            $("select.cities").val(selected_city);
            $("select.subcities").val(selected_sub_city);
            $("select.stores").val(selected_store);


            $("select.countries").chosen();
            $("select.states").chosen();
            $("select.cities").chosen();
            $("select.subcities").chosen();
            $("select.stores").chosen();
            $("select.categories").chosen();
            $("select.subcategories").chosen();

            $("select[name='kind']").val(booklet_kind);
            $("select[name='master_pass_required']").val(master_pass_required);
            $("select[name='price_type']").val(selected_price_type);
            $("select[name='redeem_offline']").val(selected_redeem_offline);

            $("select[name='reach']").val(selected_reach);

            $("select[name='kind']").chosen();
            $("select[name='master_pass_required']").chosen();
            $("select[name='price_type']").chosen();
            $("select[name='type']").chosen();

            $("select[name='reach']").chosen();


            if (dealActive) {
                $("select[name='active']").val(dealActive);
            } else {
                $("select[name='active']").val(1);
            }

            $("select[name='active']").chosen();

            @if($form_type === 'patch')
            getStoreDetails(storeID);
            $("select.categories").val(selected_categories);
            $("select.categories").trigger('chosen:updated');
            $("select.subcategories").val(selected_sub_categories);
            $("select.subcategories").trigger('chosen:updated');
            @else
            clubCK.val(text_club_terms);
            storeCK.val(text_store_terms);
            getCountryDetails(1);
            @endif
        });
    </script>
@append

@section('scripts')
    <script src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('js/datetimepicker.js') }}"></script>

    <script src="{{ asset('js/bootstrap-imageupload.js') }}"></script>

    <script>
        $(document).ready(function () {
            // $('#beginDate').datepicker();
            // $('#endDate').datepicker();
        });
    </script>
    <script>
        var $imageupload = $('.imageupload');
        $imageupload.imageupload();

        $('#imageupload-disable').on('click', function () {
            $imageupload.imageupload('disable');
            $(this).blur();
        });

        $('#imageupload-enable').on('click', function () {
            $imageupload.imageupload('enable');
            $(this).blur();
        });

        $('#imageupload-reset').on('click', function () {
            $imageupload.imageupload('reset');
            $(this).blur();
        });
    </script>
@append
