@component('mail::message')
# Introduction

The body of Test Message message.

@component('mail::button', ['url' => route('home')])
Visit Us again
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
