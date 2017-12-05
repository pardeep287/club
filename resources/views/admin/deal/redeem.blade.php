@extends('layouts.app')
@section('content')

    <div class="page-title">
        <h1>Redeem a deal</h1>
    </div>

    <article class="panel panel-default">
        <header class="panel-heading">
            Input Coupon code and Validate
        </header>
        <section class="panel-body">
            <form action="{{ route("deal.redeem") }}">
                <fieldset class="row">
                    <div class="col-md-10">
                        <input type="text" name="coupon" class="form-control" placeholder="Deal Coupon Code"
                               value="{{ (null !== old('coupon')) ? "-" : app('request')->input('coupon') }}">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block">
                            Validate
                        </button>
                    </div>
                </fieldset>
            </form>
        </section>
    </article>

    <article>
        @if(app('request')->input('coupon'))
            @if($dealCoupons->count() > 0)
                @foreach($dealCoupons as $dealCoupon)
                    <section class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group stacked">
                                        @if($dealCoupon->status === 'purchased' || $dealCoupon->status === 'active')
                                            <li class="list-group-item">
                                                <small>Client Name:</small>
                                                <strong>{{ $dealCoupon->client->name }}</strong>
                                            </li>
                                            <li class="list-group-item">
                                                <small>Client Mobile:</small>
                                                <strong>{{ $dealCoupon->client->mobile }}</strong>
                                            </li>
                                            <li class="list-group-item">
                                                <small>Transacted On:</small>
                                                <strong>{{ $dealCoupon->updated_at }}</strong>
                                            </li>
                                        @endif
                                        <li class="list-group-item list-group-item-{{ $dealCoupon->statusClass() }}">
                                            <small>Status:</small>
                                            <strong>{{ ucwords($dealCoupon->status) }}</strong>
                                        </li>
                                        <li class="list-group-item">
                                            <small>Created On:</small>
                                            <strong>{{ ucwords($dealCoupon->created_at) }}</strong>
                                        </li>

                                        @if($dealCoupon->status === 'purchased')
                                            <li class="list-group-item">
                                                <form action="{{ route('deal.redeem') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="coupon"
                                                           value="{{ app('request')->input('coupon') }}">
                                                    <input type="hidden" name="dealCouponID"
                                                           value="{{ $dealCoupon->id }}">

                                                    <button class="btn btn-success">
                                                        Activate
                                                    </button>
                                                </form>
                                            </li>
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @include("admin.deal.details.main", ['deal' => $dealCoupon->deal])
                                    @include("admin.deal.details.store", ['deal' => $dealCoupon->deal])
                                </div>
                            </div>
                        </div>

                        <footer class="panel-footer">
                        </footer>

                    </section>
                @endforeach
            @else
                <section class="panel panel-danger">
                    <header class="panel-heading">
                        No Coupons relating to <strong>{{ app('request')->input('coupon') }}</strong>
                    </header>
                </section>
            @endif
        @endif
    </article>
@endsection
