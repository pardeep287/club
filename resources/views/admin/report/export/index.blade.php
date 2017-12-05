@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <div class="page-header">
                    <h1>Reporting Downloads</h1>
                </div>
                <div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>CC Avenue Reports</h4>
                        </div>
                        <form id="ccAvenueReports" class="panel-body" action="{{ route('export.ccData') }}"
                              method="post">
                            {!! csrf_field() !!}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Joining Reports</h4>
                            <h6>All sales team data included</h6>
                        </div>
                        <form id="clientDataReports" class="panel-body" action="{{ route('export.clientData') }}"
                              method="post">
                            {!! csrf_field() !!}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Device Register Reports</h4>
                        </div>
                        <form id="clientDataReports" class="panel-body" action="{{ route('export.deviceRegData') }}"
                              method="post">
                            {!! csrf_field() !!}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Team Reports</h4>
                            <h6>Select Team Data</h6>
                        </div>
                        <form id="teamEffortReports" class="panel-body"
                              action="{{ route('export.salesRegisterationsData') }}"
                              method="post">
                            {!! csrf_field() !!}

                            <div class="col-md-12">
                                @include('layouts.select.sales', ['type' => 'multiple'])
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Booklet Activations</h4>
                        </div>

                        <form id="bookletActivationReports" class="panel-body"
                              action="{{ route('export.bookletActivationData') }}"
                              method="post">
                            {!! csrf_field() !!}

                            <div class="col-md-12">
                                @include('layouts.select.city')
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h4>Store wise Deal Reports</h4>
                        </div>

                        <form id="storeDataReports" class="panel-body" action="{{ route('export.storeOrderData') }}"
                              method="post">
                            {!! csrf_field() !!}

                            <div class="col-md-12">
                                @include('layouts.select.store')
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="begin">Begin</label>
                                    <input type="text" class="form-control" name="begin"
                                           value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end">End</label>
                                    <input type="text" class="form-control" name="end"
                                           value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Store Deals</h4>
                            <h5>Just the List of Deals the store is giving</h5>
                        </div>
                        <form id="storeDataReports" class="panel-body" action="{{ route('export.storeDealData') }}"
                              method="post">
                            {!! csrf_field() !!}

                            <div class="col-md-8">
                                @include('layouts.select.store')
                            </div>

                            <div class="col-md-4">

                                <button class="btn btn-primary">
                                    <i class="fa fa-cloud-download"></i> Download
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        var dateFormat = "yy-mm-dd";
        datePickerOptions = {
            dateFormat: dateFormat
        };

        var ccAvenueBegin, ccAvenueEnd;
        var clientDataBegin, clientDataEnd;
        var storeDataBegin, storeDataEnd;
        var bookletActivationBegin, bookletActivationEnd;
        var effortDataBegin, effortDataEnd;

        $(function () {
            ccAvenueBegin = $("#ccAvenueReports").find("input[name='begin']");
            ccAvenueEnd = $("#ccAvenueReports").find("input[name='end']");
            initialiseDateRange(ccAvenueBegin, ccAvenueEnd);

            clientDataBegin = $("#clientDataReports").find("input[name='begin']");
            clientDataEnd = $("#clientDataReports").find("input[name='end']");
            initialiseDateRange(clientDataBegin, clientDataEnd);

            storeDataBegin = $("#storeDataReports").find("input[name='begin']");
            storeDataEnd = $("#storeDataReports").find("input[name='end']");
            initialiseDateRange(storeDataBegin, storeDataEnd);

            bookletActivationBegin = $("#bookletActivationReports").find("input[name='begin']");
            bookletActivationEnd = $("#bookletActivationReports").find("input[name='end']");
            initialiseDateRange(bookletActivationBegin, bookletActivationEnd);

            effortDataBegin = $("#teamEffortReports").find("input[name='begin']");
            effortDataEnd = $("#teamEffortReports").find("input[name='end']");
            initialiseDateRange(effortDataBegin, effortDataEnd);

            $('#storeDataReports').find('select.stores').chosen();
            $("#bookletActivationReports").find("select.cities").chosen();
            $("#teamEffortReports").find("select.sales").chosen();
            $("#teamEffortReports").find("select.sales option").prop('selected', true);
            $("#teamEffortReports").find("select.sales").trigger('chosen:updated');
        });
    </script>
@append