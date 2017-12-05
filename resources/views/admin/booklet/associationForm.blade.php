<form action="{{ route('booklet_associate', $booklet->id) }}" class="form" method="post">
    {{ csrf_field() }}
    @foreach($stores as $store)
        <div class="form-group">
            <h3>{{ $store->name }}</h3>
            @foreach($store->deals->where('kind','booklet') as $deal)
                <div class="row">
                    <div class="col-md-1">
                        <a id="da-{{ $deal->id }}" href="{{route('deal.view')}}?deal={{ $deal->id }}" target="_blank">
                            # <strong>{{ $deal->id }}</strong></a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('deal.view')}}?deal={{ $deal->id }}" target="_blank">
                            <img src="{{ asset($deal->imageAvatar()) }}" alt="{{ $deal->title }}"
                                 class="img img-responsive img-thumbnail">
                        </a>
                    </div>
                    <div class="col-md-3">
                        <label for="daily_limit" class="form-controllabel">Deal</label>
                        @if($deal->active)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" @if($booklet->deals->contains($deal)) checked
                                           @endif name="deal[]" value="{{ $deal->id }}"> {{ $deal->title }}
                                </label>
                            </div>
                        @else
                            {{ $deal->title }} is <strong>INACTIVE</strong>
                        @endif
                    </div>
                    <div class="col-md-1">
                        <label for="quantity" class="form-controllabel">Quantity</label>
                        <input type="number" class="form-control" name="details[{{ $deal->id }}][quantity]"
                               placeholder="Max Quantity"
                               value="{{ (isset($booklet->deals->where('id', $deal->id)->first()->id)) ? $booklet->deals->where('id', $deal->id)->first()->pivot->quantity : '0' }}"
                               max="{{ $deal->max_quantity }}" min="0">
                    </div>
                    <div class="col-md-1">
                        <label for="daily_limit" class="form-controllabel">Daily Limit</label>
                        <input type="number" class="form-control" name="details[{{ $deal->id }}][daily_limit]"
                               placeholder="Max Daily Limit"
                               value="{{ (isset($booklet->deals->where('id', $deal->id)->first()->id)) ? $booklet->deals->where('id', $deal->id)->first()->pivot->daily_limit : '0' }}"
                               max="{{ $deal->max_daily_limit }}" min="0">
                    </div>
                </div>
            @endforeach
        </div>

        <hr>

    @endforeach

    <div class="form-group">
        <button class="btn btn-primary pull-right">
            Submit
        </button>

    </div>

</form>