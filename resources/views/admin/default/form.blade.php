@if(authority_match(\App\User::$admin))
<form class="row" method="post" action="{{ route($formaction) }}" enctype="multipart/form-data">
    {{ csrf_field() }} {!! method_field($formmethod) !!}
    <div class="@if(isset($modal)) col-md-12 @else col-md-4 @endif">
        <div class="form-group">
            <label>Key</label>
            <input class="form-control" name="key" type="text" value="{{ old('key') }}" required>
        </div>
    </div>
    <div class="@if(isset($modal)) col-md-12 @else col-md-4 @endif">
        <div class="form-group">
            <label>Value</label>
            <textarea class="form-control" @if(isset($modal)) rows='8' @endif name="value" required>{{ old('value') }}</textarea>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <br/>
            <input name="id" type="hidden">
            @if(!isset($modal))
            <button class="btn btn-primary"><i class="fa fa-cogs"></i> Add Pair</button>
            @endif
        </div>
    </div>
</form>

@section('scripts')
<script>
    $(function(){
        $("div.panel-heading textarea[name='value']").ckeditor()
    });
</script>
@append

@endif