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
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#booklet-list" data-toggle="tab">Booklets</a></li>
                        <li><a href="#orders-list" data-toggle="tab">Orders</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="booklet-list">
                            <div id="booklet-list" class="panel panel-default">
                                <div class="panel-heading">Client Booklets</div>
                                <div class="panel-body">
                                    @include('layouts.table', [
                                        'rows' => $client->booklets,
                                        'columns' => [
                                            'id',
                                            'name',
                                            'price',
                                            'code',
                                            'purchased_on',
                                            'client_code_id'
                                            ],
                                        'buttons' => [
                                            'get_booklets' => [
                                                'text' => "Booklet Details",
                                                'class' => 'primary',
                                                'onclick' => 'getBookletDetails(this)',
                                                'data' => [
                                                    'toggle'=>'modal',
                                                    'target' => '#getBookletDetails'
                                                    ]
                                                ]
                                            ]
                                    ])
                                    @section('scripts')
                                        <script>
                                            var bookletDetailsPanel = $('#booklet-details');
                                            var bookletListPanel = $('#booklet-list');
                                            bookletDetailsPanel.hide();
                                            var url = "{{ route('html_booklet_deals') }}";

                                            function getBookletDetails(button) {
                                                button = $(button);
                                                data = {
                                                    'id': button.data('id'),
                                                    'client_mobile': '{{ $client->mobile }}'
                                                };

                                                $.post(url, data, function (response) {
                                                    bookletDetailsPanel.find('div.panel-body').html(response);
                                                    bookletDetailsPanel.find('table').DataTable();
                                                    $(".dataTables_wrapper select, .dataTables_wrapper input").addClass("form-control");
                                                    bookletDetailsPanel.show();
                                                });
                                            }

                                            function changeBooklet() {
                                                bookletDetailsPanel.hide();
                                            }
                                        </script>
                                        <script>
                                            $('button.booklet_deals').on('click', function (event) {
                                                var button = $(event.target);
                                            });
                                        </script>
                                    @append
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders-list">
                            <div class="panel panel-default">
                                <div class="panel-heading">Orders</div>
                                <div class="panel-body">
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
                </div>
            </div>
        </div>
    </div>

    <div id="booklet-details" class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Booklet Details
                <button class="btn btn-sm btn-primary pull-right" onclick="changeBooklet()">
                    <span class="fa fa-close"></span> Close
                </button>
            </div>
            <div class="panel-body">
            </div>
        </div>
    </div>
    </div>

@endsection


@push('datatables')

    <script>

        var ordersTable = $("#orders-list table");
        $(initialiseDataTable(ordersTable));

        var bookletsTable = $("#booklet-list table");
        $(initialiseDataTable(bookletsTable));

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