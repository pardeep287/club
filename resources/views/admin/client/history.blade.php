@extends('layouts.app') @section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="{{ route('client') }}"><span class="fa fa-book"></span> Clients</a></li>
            <li class="active"><span class="fa fa-money"></span> History</li>
        </ol>
    </div>
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <img src="{{ $client->imageAvatar() }}" alt="{{ $client->name }}" width="128"
                         class="col-md-1 col-md-offset-1 img-thumbnail">
                    <div class="col-md-10">
                        <h3>
                            {{ $client->name }}
                            <div class="btn-group pull-right">
                                <a class="btn btn-warning"
                                   href="{{ route('client.avail.deal') }}?mobile={{ $client->mobile }}">
                                    Deals
                                </a>
                                <a class="btn btn-info"
                                   href="{{ route('client_referrals') }}?mobile={{ $client->mobile }}">
                                    Referrals: {{ $client->everyReferral }}
                                </a>
                            </div>
                        </h3>
                        <h4>
                            Joined Club JB on {{ $client->created_at }}
                        </h4>

                        <div>
                            <strong>{{ $client->formattedAddress() }}</strong>
                            <p>{{ $client->email }}</p>
                            <p>{{ $client->mobile }}</p>
                            <p>Device : {{ ($client->device_id) ? $client->device_id : '________' }}</p>
                            <p>{{ $client->city->name }}</p>
                            <p>{{ $client->city->state->country->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Orders
                </div>
                <div id="orders-list" class="panel-body">
                    @include('layouts.table',[
                    'rows' => $orders,
                    'columns' => [
                        'id', 'redeem_mode','status', 'remarks', 'created_at', 'updated_at'
                    ],
                    'special_columns' => [
                        'deal' => ['title'],
                        'dealCoupon' => ['code'],
                    ]
                ])
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        {{ $orders->appends(['mobile' => $client->mobile ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('datatables')

    <script>

        var ordersTable = $("#orders-list table");
        $(initialiseDataTable(ordersTable));

        $(function () {
            var oTable = ordersTable.dataTable();
            var oSet = oTable.fnSettings();
            oSet.bInfo = false;
            oSet.bPaginate = false;
            oTable.fnDestroy();
            ordersTable.dataTable(oSet);
        });
    </script>

@endpush