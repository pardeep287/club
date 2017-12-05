@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('images/payment-banner.jpg') }}" class="img-responsive"/>
@endcomponent
@endslot

# {{ ucwords($order->deal->title) }}
### At {{ ucwords($order->deal->store->name) }}, {{ ucwords($order->deal->store->city->name) }}
---

@if($order->status=='success')

@component('mail::alert', ['alert_type' => 'alert-success', 'prefix' => "USE Code: "]) {{ $order->dealCoupon->code }} @endcomponent

@else

@component('mail::alert', ['alert_type' => 'alert-danger', 'prefix' => "Sorry, "]) {{ 'Deal is: ' . $order->status }} @endcomponent

@endif

---

|*Transaction*|*Information*|
|:------------|:------------|
|**Order**|# {{ ucwords($order->id) }}|
|**Status**|{{ ucwords($order->status) }}|
|**Type**|{{ ucwords($order->redeem_mode) }}|
|**Code**|{{ ucwords($order->dealCoupon->code) }}|
|**Placed On**|{{ ucwords($order->created_at) }}|

@component('mail::button', ['url' => route('home'), 'color'=> 'orange'])
Visit Us for More
@endcomponent


{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
You can always view your used coupons under 'My coupons' section found within 'My Profile'
@endcomponent
@endslot


Thanks,<br>
{{ config('app.name') }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
@endcomponent
@endslot

@endcomponent