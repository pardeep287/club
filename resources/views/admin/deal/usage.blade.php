@if(session("status"))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <em>{{session('status')}}</em> @if(session("transaction"))
    strong>{{session("transaction")}}</strong> @endif @if(session("left")) You can use <strong>{{session("left")}}</strong> more times till deal expires @if(session("left_today")) and <strong>{{session("left_today")}}</strong> today @else but not today @endif . @else You have used this deal to a <strong> Maximum </strong>. @endif
    &nbsp; <em>Thank You!</em>
</div>
@endif