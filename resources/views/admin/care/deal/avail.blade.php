@extends('layouts.app')
@section('content')

    <header class="page-header">
        <h1>
            Redemption Portal
        </h1>
        @if(!is_null($client))
            <h4>
                for
                <a href="{{ route('client.history') . "?mobile={$client->mobile}" }}"
                   target="_blank">{{ "{$client->name}, {$client->mobile}" }}</a>
            </h4>
        @endif
        <form id="clientAvailForm" class="row" action="{{ route('client.avail.deal') }}">
            <div class="col-md-3">
                <label for="mobile">Client's Mobile</label>
                <input type="text" name="mobile" class="form-control"
                       value="{{ (!is_null($client)) ? $client->mobile: ""}}">
            </div>
            <div class="col-md-3">
                @include('layouts.select.city')
            </div>
            <div class="col-md-3">
                @include('layouts.select.store')
            </div>
            <div class="col-md-3">
                <label for="submit">Go</label>
                <input type="submit" class="form-control btn-primary" value="Fetch Deals">
            </div>
        </form>
    </header>

    <div class="panel-group" id="usableDeals">
        @if(!is_null($client))
            <div class="panel panel-default">
                <h2 class="panel-heading">Send message</h2>
                <form class="panel-body" action="{{route('client.send.sms')}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="mobile" value="{{ $client->mobile }}">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="message" placeholder="Message to be sent">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success">
                            Send
                        </button>
                    </div>
                </form>
            </div>

            <div class="panel panel-info">
                <h2 class="panel-heading">Bonus Deals Availed</h2>
                <section class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Bonus</th>
                            <th>Given For</th>
                            <th>Code</th>
                            <th>Redeem</th>
                            <th>Last Action on</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($client->bonusCoupons->count() > 0)
                            @foreach($client->bonusCoupons as $bonus)
                                <tr class="">
                                    <td>{{ $bonus->bonusDeal->title }}</td>
                                    <td>{{ $bonus->bonusDeal->type }}</td>
                                    <td>{{ $bonus->code }}</td>
                                    <td>
                                        @if($bonus->redeemed)
                                            REDEEMED
                                        @else
                                            <form action="{{ route('bonusdealcode.update', $bonus) }}" method="post">
                                                {!! csrf_field() !!}
                                                {!! method_field('patch') !!}
                                                <input type="hidden" name="city_id" value="{{ $city->id }}">
                                                <input type="hidden" name="mobile" value="{{ $client->mobile }}">

                                                <button class="btn btn-success">
                                                    <strong>Redeem</strong>
                                                </button>

                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $bonus->updated_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="4">
                                    No Records
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </section>
            </div>

            @if(!is_null($store) && $store->deals()->where('kind','loose')->count() > 0)
                @include('admin.care.deal.dealsPanel', [
                    'panelID' => "store-deals",
                    'title' => "{$store->name} {$store->city->name} Specific Deals",
                    'deals' => $store->deals()->where('kind','loose')->get(),
                    'client_code_id' => ""
                  ])
            @endif

            @include('admin.care.deal.dealsPanel', [
                'panelID' => "cityDeals",
                'title' => "{$city->name} Specific Deals",
                'deals' => $city->deals,
                'client_code_id' => ""
              ])

            @foreach($client->booklets as $booklet)
                @include('admin.care.deal.dealsPanel', [
                    'panelID' => "bk-{$booklet->code}",
                    'title' => "{$booklet->name} for {$booklet->city->name} [{$booklet->code}] Expiry: {$booklet->expires_on->format("Y-m-d")}",
                    'deals' => $booklet->deals,
                    'client_code_id' => $booklet->client_code_id
                  ])
            @endforeach

        @else
            <div class="panel panel-danger">
                <div class="panel-heading">NO Client Selected</div>
                <div class="panel-body">
                    <p>
                        Find a user to get deal listing.
                    </p>

                    @if(request()->input('mobile'))
                        <p class="text-danger">The mobile number <strong>{{ request()->input('mobile') }}</strong> not
                            found.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        var selected_city = "{{ $city->id }}";
        var selected_store = "{{ $store->id }}";

                @if(!is_null($client))
        var client_mobile = "{{ $client->mobile }}";
        var deal_redeem = "{{ route('api.deal.redeem') }}";
        var auth_user = "{!! Auth::user()->mobile !!}";

        function availDeal(button) {
            if (confirm("Are you sure?")) {
                if (confirm("Process the Deal?")) {
                    button = $(button);

                    $("#" + button.data('parent') + " tr.deal-" + button.data('deal_id') + " td.response.message img").show();
                    $("#" + button.data('parent') + " tr.deal-" + button.data('deal_id') + " td.response.message span").text("");

//                    var masterPass = prompt("Master Pass for Store");
                    var masterPass = button.data('master_pass');


                    if (masterPass == null || masterPass == "") {
                        alert("Redemption Cancelled");
                        $("#" + button.data('parent') + " tr.deal-" + button.data('deal_id') + " td.response.message img").hide();
                        $("#" + button.data('parent') + " tr.deal-" + button.data('deal_id') + " td.response.message span").text("-");
                    }

                    var invoice = prompt("CC Avenue Invoice ID");

                    if (invoice == null) {
                        alert("Invoice ID is must.");
                        return;
                    }

                    var data = {
                        'mobile': client_mobile,
                        'deal_id': button.data('deal_id'),
                        'redeem_mode': 'offline',
                        'master_pass': masterPass,
                        'client_code_id': button.data('client_code_id'),
                        'remarks': "Customer Care Redeem, Redeemer: " + auth_user + ", CC_Inv: " + invoice + "."
                    };

                    $.post(
                        deal_redeem,
                        data,
                        function (response) {
                            console.log(response);
                            console.log(formatResponse(response));
                            redeemed(button.data('parent'), data.deal_id, response);
                        }
                    );
                    return;
                }
            }

            alert("Processing canceled");

        }

        function redeemed(parent, deal_id, response) {
            $("#" + parent + " tr.deal-" + deal_id + " td.response.message img").hide();
//            $("#" + parent + " tr.deal-" + deal_id + " td.response.message span").text(response.code.message.capitalize());
            $("#" + parent + " tr.deal-" + deal_id + " td.response.message span").html(formatResponse(response));
        }

        function formatResponse(response) {
            var text = "<strong>Today's Usability:</strong> " + response.today.status.capitalize();
            text += "<br><strong>Lifetime's Usability:</strong> " + response.lifetime.status.capitalize();
            text += "<br><strong>Redemption:</strong> " + response.redemption.message.capitalize();
            text += "<br><strong>Usable Code:</strong> " + response.code.message.capitalize();

            return text;
        }

        @endif

        $(function () {
            $('select.cities').val(selected_city);
            $('select.stores').val(selected_store);
            $('td.response.message img').hide();
        });

        //        $("select.cities").change(function () {
        //            $("form#clientAvailForm").submit();
        //        })
    </script>
@append

@section('scripts')
    <script>
        var changeCountryRoute = "{{ route('api_get_country') }}";
        var changeStateRoute = "{{ route('api_get_state') }}";
        var changeCityRoute = "{{ route('api_get_city') }}";
    </script>
    <script src="{{ asset('/js/lakshay.js') }}"></script>
@append
