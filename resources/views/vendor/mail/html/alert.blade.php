---
{{$prefix}}
<span class="alert {{ (null !== ($alert_type)) ? $alert_type : 'alert-normal' }}">
    {{ $slot }}
</span>
---