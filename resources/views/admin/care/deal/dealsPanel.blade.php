<article class="panel panel-default">
    <header class="panel-heading">
        <div class="panel-title">
            <a data-toggle="collapse" data-parent="#usableDeals" href="#{{ $panelID }}">
                <strong>{{ "{$title} Deals: {$deals->count()}" }}</strong>
            </a>
        </div>
    </header>

    <div id="{{ $panelID }}" class="panel-collapse collapse">
        <section class="panel-body">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Store</th>
                    <th>Expires</th>
                    <th>Action</th>
                    <th>Response</th>
                </tr>
                </thead>

                <tbody>
                @foreach($deals as $deal)

                    <tr class="deal-{{$deal->id}}">
                        <td>
                            <img style="width: 142px" class="img img-thumbnail"
                                 src="{{ $deal->thumbAvatar()}}"
                                 alt="{{ "{$deal->title}" }}">
                        </td>
                        <td>
                            <a href="{{ route('deal.view') . "?deal={$deal->id}" }}" target="_blank">
                                {{ $deal->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('query_store') . "?id={$deal->store->id}" }}" target="_blank">
                                {{  $deal->store->name }}
                            </a>
                        </td>

                        <td>
                            {{ $deal->end->format('Y-m-d') }}
                        </td>

                        <td>
                            @if($deal->redeemMode === 'offline')
                                @if($deal->end->gte(\Carbon\Carbon::today()))
                                    <button class="btn btn-primary" onclick="availDeal(this)"
                                            data-parent="{{ $panelID }}"
                                            data-deal_id="{{ $deal->id }}"
                                            data-master_pass="{{ $deal->master_pass }}"
                                            data-client_code_id="{{ $client_code_id }}">
                                        Avail Deal
                                    </button>
                                @else
                                    <span class="text-danger">
                                        Deal EXPIRED
                                    </span>
                                @endif
                            @else
                                DEAL PAYMENT Is ONLINE
                            @endif

                        </td>
                        <td class="response message">
                            <img width="48" height="48" src="{{ asset('/images/double_ring_loader.gif') }}">
                            <span>-</span>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </section>
    </div>
</article>
