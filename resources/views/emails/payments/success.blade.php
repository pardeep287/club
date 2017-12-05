@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('images/payment-banner.jpg') }}" class="img-responsive"/>
@endcomponent
@endslot

## Your order for {{ $transaction->order_type }} was a {{ $transaction->status }}<br>

---

@if($transaction->status=='success')

@component('mail::alert', ['alert_type' => 'alert-success', 'prefix' => "USE Code: "]) {{ $transaction->report['code'] }} @endcomponent

@else

@component('mail::alert', ['alert_type' => 'alert-danger', 'prefix' => "Sorry, "]) {{ $transaction->report['code'] }} @endcomponent

@endif

---

|*Transaction*|*Information*|
|:------------|:------------|
|**Order**|# {{ ucwords($transaction->id) }}|
|**Status**|{{ ucwords($transaction->status) }}|
|**Type**|{{ ucwords($transaction->order_type) }}|
|**Code**|{{ ucwords($transaction->report['code']) }}|
|**Placed On**|{{ ucwords($transaction->created_at) }}|
|**Amount**|{{ $transaction->amount }}|
|**Payment Reference**|#{{ ucwords($transaction->tracking_id) }}|

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