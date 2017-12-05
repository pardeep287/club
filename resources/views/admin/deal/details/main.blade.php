<style>
    ul.list-group.stacked:after {
        clear: both;
        display: block;
        content: "";
    }

    ul.list-group.stacked .list-group-item {
        float: left;
        font-size: 0.9em;
    }
</style>

<div class="row">
    <div class="col-sm-12 col-md-2">
        <img src="{{ $deal->completeAvatar }}" alt="{{ $deal->title }}" title="{{ $deal->title }}"
             class="img img-responsive img-thumbnail">
    </div>
    <div class="col-sm-12 col-md-10">
        <div class="row">
            <div class="col-md-7">
                <h3>{{ $deal->title }}</h3>
            </div>
            <div class="col-md-5">
                @if(auth()->user()->is_admin())
                    <div class="btn-group">
                        <a class="btn btn-primary"
                           href="{{ route("deal_coupons")  }}?id={{$deal->id}}"><i
                                    class="fa fa-ticket"></i>
                            Coupons Left: <strong>{{ $deal->couponsLeft }}</strong>
                        </a>
                        <a class="btn btn-warning"
                           href="{{ route("deal_edit_page")  }}?id={{$deal->id}}">
                            <i class="fa fa-edit"></i>
                            <strong>Edit Deal</strong>
                        </a>
                    </div>
                @else
                    <div class="btn btn-primary">
                        Coupons Left: <strong>{{ $deal->couponsLeft }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <ul class="list-group stacked">
                <li class="list-group-item">
                    <strong>Deal Status</strong> {{ ($deal->active) ? "Active" : "Inactive" }}
                </li>
                <li class="list-group-item">
                    <strong>Begin:</strong> {{ $deal->begin->format('d-M-Y') }}
                </li>
                <li class="list-group-item">
                    <strong>End:</strong> {{ $deal->end->format('d-M-Y') }}
                </li>
                <li class="list-group-item">
                    <strong>Expires:</strong> {{ $deal->daysLeftHuman }}
                </li>
                @if(authority_match('admin'))
                    <li class="list-group-item list-group-item-danger">
                        <strong>MasterPass: </strong> {{ ($deal->master_pass_required) ? $deal->master_pass : "---" }}
                    </li>
                @endif
            </ul>
        </div>


        <div class="row">
            <ul class="list-group stacked">
                <li class="list-group-item">
                    <strong>Price:</strong> ₹{{ $deal->price }}/-
                </li>

                <li class="list-group-item">
                    <strong>Handling Fee:</strong> ₹{{ $deal->handling_fee }}/-
                </li>

                <li class="list-group-item">
                    <strong>Discount Type:</strong> {{ ucwords($deal->discount_type) }}
                </li>

                <li class="list-group-item">
                    <strong>Discount Value:</strong> {{ $deal->discount_value }}
                </li>
            </ul>
        </div>

        <div class="row">
            <blockquote>
                {{ $deal->discountMessage }}
            </blockquote>
        </div>

        <div class="row">
            <a class="btn btn-sm btn-info" href="{{route('deal.view')}}?deal={{ $deal->id }}">
                More &blacktriangleright;&blacktriangleright;&blacktriangleright;
            </a>
        </div>
    </div>
</div>